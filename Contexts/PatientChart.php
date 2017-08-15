<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class PatientChart extends BaseContext
{
    /**
     * @When I type :name into patient search form
     *
     * @param string $name
     */
    public function fillPatientSearchForm($name)
    {
        $this->page->fillField('patient_search', $name);
    }

    /**
     * @When I click on :name in list of patients
     *
     * @param string $name
     * @throws BehatException
     */
    public function clickPatientInList($name)
    {
        $patients = $this->findAllCss('ul#patient_list li.json_patient');
        foreach ($patients as $patient) {
            if ($this->sanitizeText($patient->getText()) == $name) {
                $patient->click();
                return;
            }
        }
        throw new BehatException("Patient with name $name not found");
    }

    /**
     * @When I fill add patient form with values:
     *
     * @param TableNode $table
     */
    public function fillAddPatientForm(TableNode $table)
    {
        $form = $this->findCss('form#patientfrm');
        $data = $table->getHash();
        foreach ($data as $field) {
            $label = $this->findElementWithText('label', $field['field'], $form);
            $fieldId = $label->getAttribute('for');
            $this->page->fillField($fieldId, $field['value']);
        }
    }

    /**
     * @When I click on :menuPoint patient chart menu point
     *
     * @param string $menuPoint
     */
    public function clickPatientChartMenu($menuPoint)
    {
        $list = $this->findCss('div#patient_nav > ul');
        $link = $this->findElementWithText('a', $menuPoint, $list);
        $link->click();
    }

    /**
     * @Then I see patient search form
     */
    public function testPatientSearchForm()
    {
        $input = $this->findCss('input#patient_search');
        Assert::assertNotNull($input);
    }

    /**
     * @Then I see list of patients in search form:
     *
     * @param TableNode $table
     */
    public function testPatientSearchList(TableNode $table)
    {
        $list = $this->findCss('ul#patient_list');
        Assert::assertNotNull($list);
        $patients = $this->findAllCss('li.json_patient', $list);
        $expectedPatients = array_column($table->getHash(), 'name');
        foreach ($expectedPatients as $key => $expectedPatient) {
            $patient = $this->sanitizeText($patients[$key]->getText());
            Assert::assertEquals($expectedPatient, $patient);
        }
    }

    /**
     * @Then I see patient chart for :name
     *
     * @param string $name
     */
    public function testPatientChart($name)
    {
        $span = $this->findCss('div#patient_name_inner span.name');
        Assert::assertNotNull($span);
        Assert::assertContains($name, $span->getText());
    }

    /**
     * @Then patient chart has menu with following points:
     *
     * @param TableNode $table
     */
    public function testPatientChartMenu(TableNode $table)
    {
        $menuPoints = $this->findAllCss('div#patient_nav > ul > li');
        $expectedPoints = array_column($table->getHash(), 'name');
        foreach ($expectedPoints as $key => $expectedPoint) {
            Assert::assertEquals($expectedPoint, $menuPoints[$key]->getText());
        }
    }

    /**
     * @Then I see questionnaire subpoints:
     *
     * @param TableNode $table
     */
    public function testQuestionnaireSubpoints(TableNode $table)
    {
        $expectedPoints = array_column($table->getHash(), 'name');
        $table = $this->findCss('div#contentMain > table');
        $subpoints = $this->findAllCss('td', $table);
        foreach ($expectedPoints as $key => $expectedPoint) {
            $subpointText = $this->sanitizeText($subpoints[$key]->getText());
            Assert::assertEquals($expectedPoint, $subpointText);
        }
    }

    /**
     * @Then I see :text button
     *
     * @param string $text
     */
    public function testSendRegistrationEmailButton($text)
    {
        // @todo: fill this method
    }

    /**
     * @Then I see add patient form
     */
    public function testAddPatientForm()
    {
        $form = $this->findCss('form#patientfrm');
        Assert::assertNotNull($form);
    }

    /**
     * @Then I see following patient info fields:
     *
     * @param TableNode $fields
     */
    public function testEditPatientForm(TableNode $fields)
    {
        // @todo: fill this method
    }

    /**
     * @Then I see warning with text :text and missing fields:
     *
     * @param string $text
     * @param TableNode $missingFields
     */
    public function testFormWarning($text, TableNode $missingFields)
    {
        // @todo: fill this method
    }

    /**
     * @Then I see add patient image form:
     *
     * @param TableNode $table
     */
    public function testAddImageFormFields(TableNode $table)
    {
        $this->getCommonClient()->switchToIFrame('aj_ref');

        $form = $this->findCss('form[name="imagefrm"]');
        $expectedRows = $table->getHash();
        $tableRows = $this->findAllCss("tbody > tr", $form);
        foreach ($tableRows as $key => $tableRow) {
            if (!$tableRow->isVisible()) {
                unset($tableRows[$key]);
            }
        }
        $tableRows = array_values($tableRows);
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 1;
            $column = $this->findCss("td", $tableRows[$childNumber]);
            Assert::assertContains($row['field'], $column->getText());
            Assert::assertTrue($this->checkRequiredFormElement($column, $row['required']));
            Assert::assertTrue($this->checkFormElement($column, $row['type']));
        }
    }
}
