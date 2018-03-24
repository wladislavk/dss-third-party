<?php
namespace Ds3\Libraries\Legacy;

use function is_null;
use function is_string;

require_once __DIR__ . '/CsvProcessorAdapterInterface.php';

class CsvProcessor
{
    public function processHeaderField(array &$headerFields, array $allowedFields, $column, $index)
    {
        $column = strtolower(trim($column));

        /**
         * If already stored, or if not a string, skip
         */
        if (in_array($column, $headerFields) || is_numeric($column) || !is_string($column)) {
            return;
        }

        /**
         * Save the position of the column, to retrieve the proper data field
         */
        if (array_key_exists($column, $allowedFields)) {
            $headerFields[$index] = $column;
            return;
        }

        if (!in_array($column, $allowedFields)) {
            return;
        }

        $found = array_search($column, $allowedFields);

        if (is_numeric($found)) {
            $headerFields[$index] = $column;
            return;
        }

        $headerFields[$index] = $found;
    }

    /**
     * Return an associative array with indexes, and labels, of valid CSV headers
     *
     * @param array $firstRow
     * @param array $allowedFields
     * @param array $specialFields
     * @return array|bool
     */
    public function processCsvHeader(array $firstRow, array $allowedFields, array $specialFields = [])
    {
        $headerFields = [];

        array_walk($firstRow, function ($column, $index) use (&$headerFields, $allowedFields) {
            $this->processHeaderField($headerFields, $allowedFields, $column, $index);
        });

        /**
         * No fields = no valid csv
         */
        if (!count($headerFields)) {
            return false;
        }

        /**
         * Signal special fields with negative indexes
         */
        foreach ($specialFields as $index => $each) {
            if (!in_array($each, $headerFields)) {
                $headerFields[-1 - $index] = $each;
            }
        }

        return $headerFields;
    }

    /**
     * Return a row batch of max $batchSize
     *
     * @param resource $handle
     * @param int      $batchSize
     * @return array
     */
    public function getCsvRowBatch($handle, $batchSize = 20)
    {
        $batch = [];

        for ($n = 0; $n < $batchSize; $n++) {
            $row = fgetcsv($handle, 10000, ',');

            if ($row === FALSE) {
                return $batch;
            }

            $batch[] = $row;
        }

        return $batch;
    }

    public function filterEmptyRows($row)
    {
        $row = array_filter($row, [$this, 'filterEmptyElements']);

        if ($row) {
            return true;
        }

        return false;
    }

    public function filterEmptyElements($each)
    {
        if (is_null($each)) {
            return false;
        }

        if (!is_string($each)) {
            return true;
        }

        if (trim($each) === '') {
            return false;
        }

        return true;
    }

    /**
     * Translate a batch of CSV rows, and insert them into the DB
     *
     * @param array                        $rowBatch
     * @param array                        $headerFields
     * @param CsvProcessorAdapterInterface $csvProcessor
     * @param int                          $docId
     * @param string                       $ipAddress
     * @return int
     */
    public function processCsvRowBatch(
        array $rowBatch,
        array $headerFields,
        CsvProcessorAdapterInterface $csvProcessor,
        $docId,
        $ipAddress
    )
    {
        $rowBatch = array_filter($rowBatch, [$this, 'filterEmptyRows']);

        $dataBatch = array_map(function ($row) use ($headerFields, $docId, $ipAddress, $csvProcessor) {
            return $csvProcessor->processRow($row, $headerFields, $docId, $ipAddress);
        }, $rowBatch);

        if (!count($dataBatch)) {
            return 0;
        }

        $inserted = $csvProcessor->storeRows($headerFields, $dataBatch);
        return $inserted;
    }

    /**
     * Encapsulate logic to read csv and insert data into the DB.
     *
     * @param string                       $filename
     * @param CsvProcessorAdapterInterface $csvProcessor
     * @param int                          $docId
     * @param string                       $ipAddress
     * @param bool                         $ignoreExtension
     * @return array
     */
    public function saveCsvContents(
        $filename,
        CsvProcessorAdapterInterface $csvProcessor,
        $docId,
        $ipAddress,
        $ignoreExtension = false
    )
    {
        $return = [
            'inserted' => 0,
            'errors' => [],
        ];

        /**
         * Allow to ignore extension, in case the filename is a temporary file
         */
        if (!$ignoreExtension && strtolower(substr($filename, -4)) !== '.csv') {
            $return['errors'][] = 'The file does not have a .csv extension.';
            return $return;
        }

        $handle = fopen($filename, 'r');

        if ($handle === false) {
            $return['errors'][] = 'The file could not be read.';
            return $return;
        }

        set_time_limit(0);
        $batchSize = 20;

        $firstRow = fgetcsv($handle, 1000, ',');

        if ($firstRow === FALSE) {
            $return['errors'][] = 'The file is empty';
            return $return;
        }

        $headerFields = $csvProcessor->getHeaders();

        if ($csvProcessor->headerNeedsIndexing()) {
            $headerFields = $this->processCsvHeader(
                $firstRow, $csvProcessor->getHeaders(), $csvProcessor->getSpecialHeaders()
            );
        }

        do {
            $rowBatch = $this->getCsvRowBatch($handle, $batchSize);

            if (count($rowBatch)) {
                $return['inserted'] += $this->processCsvRowBatch(
                    $rowBatch,
                    $headerFields,
                    $csvProcessor,
                    $docId,
                    $ipAddress
                );
            }
        } while (count($rowBatch));

        fclose($handle);
        return $return;
    }
}
