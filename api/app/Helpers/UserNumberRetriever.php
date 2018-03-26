<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\FaxRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\HomeSleepTestRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsurancePreauthRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\NoteRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientInsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PaymentReportRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SupportTicketRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Http\Controllers\InsurancesController;
use Illuminate\Database\Eloquent\Model;

class UserNumberRetriever
{
    const NUMBERED_METHODS = [
        'patient_contacts' => PatientContactRepository::class . '@getNumber',
        'patient_insurances' => PatientInsuranceRepository::class . '@getNumber',
        'payment_reports' => PaymentReportRepository::class . '@getNumber',
        'support_tickets' => SupportTicketRepository::class . '@getNumber',
        'patient_changes' => PatientRepository::class . '@getNumber',
        'pending_duplicates' => PatientRepository::class . '@getDuplicates',
        'email_bounces' => PatientRepository::class . '@getBounces',
        'completed_preauth' => InsurancePreauthRepository::class . '@getCompleted',
        'pending_preauth' => InsurancePreauthRepository::class . '@getPending',
        'rejected_preauth' => InsurancePreauthRepository::class . '@getRejected',
        'completed_hst' => HomeSleepTestRepository::class . '@getCompleted',
        'requested_hst' => HomeSleepTestRepository::class . '@getRequested',
        'rejected_hst' => HomeSleepTestRepository::class . '@getRejected',
        'pending_claims' => InsuranceRepository::class . '@getPendingClaims',
        'rejected_claims' => InsuranceRepository::class . '@getRejectedClaims',
        'unmailed_claims' => InsuranceRepository::class . '@getUnmailedClaims',
        'unmailed_claims_software' => InsuranceRepository::class . '@getUnmailedClaimsForSoftware',
        'fax_alerts' => FaxRepository::class . '@getAlerts',
        'pending_letters' => LetterRepository::class . '@getPendingNumber',
        'unmailed_letters' => LetterRepository::class . '@getUnmailed',
        'unsigned_notes' => NoteRepository::class . '@getUnsigned',
    ];

    /** @var RepositoryFactory */
    private $repositoryFactory;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }

    /**
     * @param User $user
     * @param string[] $methods
     * @return array
     */
    public function addUserNumbers(User $user, $methods = [])
    {
        $docId = $user->getDocIdOrZero();
        $numbers = [];
        if (!sizeof($methods)) {
            $methods = self::NUMBERED_METHODS;
        }
        foreach ($methods as $field => $method) {
            $methodArray = explode('@', $method);
            $numbers[$field] = $this->getNumber($field, $methodArray, $docId);
        }
        if ($user->user_type == InsurancesController::DSS_USER_TYPE_SOFTWARE && isset($numbers['unmailed_claims_software'])) {
            $numbers['unmailed_claims'] = $numbers['unmailed_claims_software'];
        }
        $userData = $user->toArray();
        $userData['numbers'] = $numbers;
        return $userData;
    }

    /**
     * @param string $field
     * @param array $methodArray
     * @param int $docId
     * @return int
     * @throws GeneralException
     */
    private function getNumber($field, array $methodArray, $docId)
    {
        if (sizeof($methodArray) < 2) {
            throw new GeneralException("Value of field $field does not contain '@' character");
        }
        $repoName = $methodArray[0];
        $methodName = $methodArray[1];
        if (!method_exists($repoName, $methodName)) {
            throw new GeneralException("Method $methodName must exist on repo $repoName");
        }
        $repo = $this->repositoryFactory->getRepository($repoName);
        return $this->extractNumber($repo->{$methodName}($docId));
    }

    /**
     * @param Model|null $result
     * @return int
     */
    private function extractNumber(Model $result = null)
    {
        if (!$result) {
            return 0;
        }
        $arrayResult = $result->toArray();
        if (!isset($arrayResult['total'])) {
            return 0;
        }
        return intval($arrayResult['total']);
    }
}
