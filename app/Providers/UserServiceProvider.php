<?php
namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\UserInterface',
            'Ds3\Admin\Repositories\UserRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\UserInterface',
            'Ds3\Repositories\UserRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LoginInterface',
            'Ds3\Repositories\LoginRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LoginDetailInterface',
            'Ds3\Repositories\LoginDetailRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\DocumentCategoryInterface',
            'Ds3\Repositories\DocumentCategoryRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\MemoAdminInterface',
            'Ds3\Repositories\MemoAdminRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LetterInterface',
            'Ds3\Repositories\LetterRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\InsuranceInterface',
            'Ds3\Repositories\InsuranceRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LedgerInterface',
            'Ds3\Repositories\LedgerRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\InsurancePreauthInterface',
            'Ds3\Repositories\InsurancePreauthRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\HomeSleepTestInterface',
            'Ds3\Repositories\HomeSleepTestRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\PatientContactInterface',
            'Ds3\Repositories\PatientContactRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\PatientInsuranceInterface',
            'Ds3\Repositories\PatientInsuranceRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\PatientInterface',
            'Ds3\Repositories\PatientRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\NoteInterface',
            'Ds3\Repositories\NoteRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\FaxInterface',
            'Ds3\Repositories\FaxRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\SupportTicketInterface',
            'Ds3\Repositories\SupportTicketRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\FlowPg2Interface',
            'Ds3\Repositories\FlowPg2Repository'
        );

        $this->app->bind(
            'Ds3\Contracts\QPage3Interface',
            'Ds3\Repositories\QPage3Repository'
        );

        $this->app->bind(
            'Ds3\Contracts\TaskInterface',
            'Ds3\Repositories\TaskRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\CompanyInterface',
            'Ds3\Repositories\CompanyRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\ContactInterface',
            'Ds3\Repositories\ContactRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\SummaryInterface',
            'Ds3\Repositories\SummaryRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\SummSleeplabInterface',
            'Ds3\Repositories\SummSleeplabRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\FlowPg1Interface',
            'Ds3\Repositories\FlowPg1Repository'
        );

        $this->app->bind(
            'Ds3\Contracts\FlowPg2InfoInterface',
            'Ds3\Repositories\FlowPg2InfoRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\PatientSummaryInterface',
            'Ds3\Repositories\PatientSummaryRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\NotificationInterface',
            'Ds3\Repositories\NotificationRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\QImageInterface',
            'Ds3\Repositories\QImageRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LocationInterface',
            'Ds3\Repositories\LocationRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LetterTemplateInterface',
            'Ds3\Repositories\LetterTemplateRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\ImageTypeInterface',
            'Ds3\Repositories\ImageTypeRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\SleeplabInterface',
            'Ds3\Repositories\SleeplabRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\InsDiagnosisInterface',
            'Ds3\Repositories\InsDiagnosisRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\DeviceInterface',
            'Ds3\Repositories\DeviceRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\ContactTypeInterface',
            'Ds3\Repositories\ContactTypeRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\QualifierInterface',
            'Ds3\Repositories\QualifierRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\CustomInterface',
            'Ds3\Repositories\CustomRepository'
        );
    }
}
