<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class PatientChart extends BaseContext
{
    /**
     * @When I fill add patient form with values:
     *
     * @param TableNode $table
     * @throws BehatException
     * @throws \Behat\Mink\Exception\ElementNotFoundException
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
     * @throws BehatException
     */
    public function clickPatientChartMenu($menuPoint)
    {
        $list = $this->findCss('div#patient_nav > ul');
        $link = $this->findElementWithText('a', $menuPoint, $list);
        $link->click();
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
     * @Then I see send registration email button
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

    /**
     * @Then the patient chart has menu with the following points:
     *
     * @param TableNode $table
     */
    public function testPatientChartMenu(TableNode $table)
    {
        $menuPoints = $this->findAllCss('div#patient_nav > ul > li');
        $expectedPoints = $table->getHash();
        foreach ($expectedPoints as $key => $expectedPoint) {
            $link = $this->findCss('a', $menuPoints[$key]);
            Assert::assertEquals($expectedPoint['name'], $link->getText());
            if ($expectedPoint['active'] == 'Yes') {
                Assert::assertTrue($link->hasClass('nav_active'));
            } else {
                Assert::assertFalse($link->hasClass('nav_active'));
            }
        }
    }
}
