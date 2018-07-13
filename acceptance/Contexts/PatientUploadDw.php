<?php

namespace Contexts;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class PatientUploadDw extends BaseContext
{
    /**
     * @param BeforeScenarioScope $scope
     */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        parent::beforeScenario($scope);
        $this->clearPatients();
    }

    public function afterScenario(AfterScenarioScope $scope)
    {
        $this->clearPatients();
    }

    private function clearPatients()
    {
        $query = "DELETE FROM dental_patients WHERE firstname = 'fir\'tname'";
        $this->executeQuery($query);
    }
}
