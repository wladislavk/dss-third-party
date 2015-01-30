<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {


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
            'Ds3\Contracts\HstInterface',
            'Ds3\Repositories\HstRepository'
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
    }

}