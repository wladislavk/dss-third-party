<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\QueryException;
use DentalSleepSolutions\Exceptions\WithBackupTraitException;

trait WithBackups
{
    /**
     * Columns that must not be altered
     *
     * @var array
     */
    private $protectedColumns = [
        'patientid',
        'patiendid',
        'patient_id',
        'parentpatientid',
        'parentpatiendid',
        'parentpatient_id',
        'parent_patientid',
        'parent_patiendid',
        'parent_patient_id',
        'docid',
        'doc_id',
        'formid',
        'form_id',
        'userid',
        'user_id',
        'status',
        'adddate',
        'ip_address',
        'referenceid',
        'reference_id',
        'epworthid',
        'epworth_id',
        'created_at',
        'updated_at'
    ];

    /** @var int */
    private $exceptionCodeIndex = 1;

    /** @var int */
    private $duplicatedRowExceptionCode = 1062;

    /**
     * Backup repository
     *
     * @return null|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function backups()
    {
        if (empty($this->backupRepositoryClass)) {
            return null;
        }

        $backupRepository = $this->hasMany($this->backupRepositoryClass, $this->primaryKey, $this->primaryKey);
        return $backupRepository;
    }

    /**
     * Create a backup of the data, to enable versions
     *
     * @param int    $userId
     * @param int    $adminId
     * @param string $ipAddress
     * @return int
     * @throws WithBackupTraitException
     */
    public function doBackup($userId=0, $adminId=0, $ipAddress='')
    {
        $backupData = $this->toArray();
        $backupRepository = $this->backups();

        if (empty($backupRepository)) {
            return 0;
        }

        // Set updated_by_user, updated_by_admin
        $backupData['updated_by_user'] = $userId;
        $backupData['updated_by_admin'] = $adminId;
        $backupData['history_ip_address'] = $ipAddress;

        /**
         * Carbon turns NULL timestamps into -0001-11-30 00:00:00, then fails to parse it
         */
        if (isset($backupData['updated_at']) && $backupData['updated_at'] === '-0001-11-30 00:00:00') {
            $backupData['updated_at'] = '0000-00-00 00:00:00';
        }

        /**
         * Handle duplicated entries
         * Error info: 1062, duplicated entry
         * Other exceptions: re-throw
         */
        try {
            $backup = $backupRepository->create($backupData);
            $backup->save();

            return $backup->getKey();
        } catch (QueryException $e) {
            $this->resetModel();

            if (
                !isset($e->errorInfo[$this->exceptionCodeIndex])
                || $e->errorInfo[$this->exceptionCodeIndex] != $this->duplicatedRowExceptionCode
            ) {
                throw new WithBackupTraitException('Model ' . self::class . ' could not complete backup', 0, $e);
            }
        }

        $this->resetModel();
        return 0;
    }

    /**
     * Set model columns to empty values, except for key columns
     */
    public function resetModel () {
        $protectedColumns = $this->protectedColumns;
        $protectedColumns[] = $this->getKeyName();

        $resetData = $this->toArray();
        $resetData = array_except($resetData, $protectedColumns);

        if (!count($resetData)) {
            return;
        }

        $resetData = array_fill_keys(array_keys($resetData), '');
        $this->update($resetData);
    }
}
