<?php
namespace Ds3\Libraries\Legacy;

interface CsvProcessorAdapterInterface
{
    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return array
     */
    public function getSpecialHeaders();

    /**
     * @return bool
     */
    public function headerNeedsIndexing();

    /**
     * @param array  $row
     * @param array  $headerFields
     * @param int    $docId
     * @param string $ipAddress
     * @return array
     */
    public function processRow(array $row, array $headerFields, $docId, $ipAddress);

    /**
     * @param array $headerFields
     * @param array $dataBatch
     * @return int
     */
    public function storeRows(array $headerFields, array $dataBatch);
}
