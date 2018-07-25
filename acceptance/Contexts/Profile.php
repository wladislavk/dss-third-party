<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Profile extends BaseContext
{
    private const SSN_LABEL = 'SSN';
    private const EIN_LABEL = 'EIN';
    private const EXISTING_EMAIL = 'email2@email.com';
    private const EXISTING_USER_NAME = 'doc2';

    /** @var boolean */
    private $userUpdated = false;

    /**
     * @Then I see practice profile form that is filled with data:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function testPracticeProfileForm(TableNode $table)
    {
        Assert::assertNotNull($this->findElementWithText('h3', 'Practice Profile'));
        $forms = $this->findAllCss('form');
        Assert::assertTrue(count($forms) > 2);
        $form = $forms[2];
        $this->basePracticeProfileCheck($form, $table);
    }

    /**
     * @Then I see profile form that is filled with data:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function testProfileForm(TableNode $table)
    {
        Assert::assertNotNull($this->findElementWithText('h3', 'My Profile'));
        $forms = $this->findAllCss('form');
        Assert::assertTrue(count($forms) > 1);
        $form = $forms[1];
        $this->basePracticeProfileCheck($form, $table);
    }

    /**
     * @When I fill profile form with values:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillProfileForm(TableNode $table)
    {
        $this->wait(SHORT_WAIT_TIME);
        $this->userUpdated = true;
        $form = $this->findAllCss('form')[1];
        $rows = $this->findAllCss('div.detail', $form);
        $visibleRows = $this->getVisibleRows($rows);
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $key => $row) {
            switch ($row['type']) {
                case 'text':
                    $input = $this->findCss('input', $visibleRows[$key]);
                    $this->setValueWithDelay($input, $row['value']);
                    break;
                case 'checkbox':
                    $this->checkSsnOrEin($row['value'], $visibleRows[$key]);
                    break;
            }
        }
    }

    /**
     * @When I fill practice profile form with values:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillPracticeProfileForm(TableNode $table)
    {
        $this->wait(SHORT_WAIT_TIME);
        $this->userUpdated = true;
        $form = $this->findAllCss('form')[2];
        $useServiceRadioButton = $this->findAllCss('input[type=radio]', $form)[2];
        $useServiceRadioButton->click();
        $this->wait(VERY_SHORT_WAIT_TIME);
        $rows = $this->findAllCss('div.detail', $form);
        $visibleRows = $this->getVisibleRows($rows);
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $key => $row) {
            switch ($row['type']) {
                case 'text':
                    $input = $this->findCss('input', $visibleRows[$key]);
                    $this->setValueWithDelay($input, $row['value']);
                    break;
                case 'radio':
                    $input = $input = $this->findCss(
                        'input[value=' . strtolower($row['value']) . ']',
                        $visibleRows[$key]
                    );
                    $input->click();
                    break;
            }
        }
    }

    /**
     * @When I click on submit button with text :text
     *
     * @param string $text
     */
    public function clickOnSubmitButtonWithText(string $text)
    {
        $button = $this->findCss('input[type=submit][value="' . $text . '"]');
        $button->click();
    }

    /**
     * @When I fill :formName form with duplicate :propertyName
     * @param string $formName
     * @param string $propertyName
     */
    public function setDuplicatePropertyValue(string $formName, string $propertyName)
    {
        $form = $this->findAllCss('form')[2];

        if ($formName == 'Profile') {
            $form = $this->findAllCss('form')[1];
        }

        $value = self::EXISTING_EMAIL;

        if ($propertyName == 'username') {
            $value = self::EXISTING_USER_NAME;
        }

        $emailInput = $this->findCss("input[name=$propertyName]", $form);
        $this->setValueWithDelay($emailInput, $value);
    }

    /**
     * @param NodeElement $input
     * @param string $value
     */
    private function setValueWithDelay(NodeElement $input, string $value)
    {
        $input->setValue($value);

        if ($input->getValue() !== $value) {
            $this->wait(SHORT_WAIT_TIME);
            $input->setValue($value);
        }
    }

    /**
     * @param NodeElement $form
     * @param TableNode $table
     * @throws BehatException
     */
    private function basePracticeProfileCheck(NodeElement $form, TableNode $table)
    {
        $this->wait(SHORT_WAIT_TIME);
        Assert::assertTrue($form->isVisible());
        $rows = $this->findAllCss('div.detail', $form);
        $visibleRows = $this->getVisibleRows($rows);
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $key => $row) {
            $label = $this->findCss('label', $visibleRows[$key]);
            $label = str_replace(':', '', $label->getText());
            $expectedLabel = $row['field'];
            if (strstr($expectedLabel, '...')) {
                $expectedLabel = str_replace('...', '', $expectedLabel);
            }
            Assert::assertContains($expectedLabel, $label);
            switch ($row['type']) {
                case 'text':
                    $input = $this->findCss('input', $visibleRows[$key]);
                    Assert::assertEquals($row['value'], $input->getValue());
                    break;
                case 'radio':
                    $input = $this->findCss(
                        'input[value=' . strtolower($row['value']) . ']',
                        $visibleRows[$key]
                    );
                    Assert::assertTrue($input->isChecked());
                    break;
                case 'checkbox':
                    $input = $this->findCss(
                        $this->getSsnOrEinCheckboxSelector($row['value']),
                        $visibleRows[$key]
                    );
                    Assert::assertTrue($input->isChecked());
                    break;
            }
        }
    }


    /**
     * @param NodeElement[] $rows
     * @return NodeElement[]
     */
    private function getVisibleRows(array $rows): array
    {
        $visibleRows = [];
        foreach ($rows as $row) {
            if ($row->isVisible()) {
                $visibleRows[] = $row;
            }
        }

        return $visibleRows;
    }

    /**
     * @param string $ssnEin
     * @param NodeElement $parentElement
     * @throws BehatException
     */
    private function checkSsnOrEin(string $ssnEin, NodeElement $parentElement)
    {
        $toCheck = self::EIN_LABEL;
        $toUncheck = self::SSN_LABEL;

        if ($ssnEin == self::SSN_LABEL) {
            $toCheck = self::SSN_LABEL;
            $toUncheck = self::EIN_LABEL;
        }

        $toCheckSelector = $this->getSsnOrEinCheckboxSelector($toCheck);
        $toUncheckSelector = $this->getSsnOrEinCheckboxSelector($toUncheck);
        $inputToCheck = $this->findCss($toCheckSelector, $parentElement);
        $inputToUncheck = $this->findCss($toUncheckSelector, $parentElement);
        $inputToCheck->check();
        $inputToUncheck->uncheck();
    }

    /**
     * @param string $ssnEin
     * @return string
     */
    private function getSsnOrEinCheckboxSelector(string $ssnEin)
    {
        $inputName = strtolower($ssnEin);
        $selector = "input[name=$inputName]";

        return $selector;
    }

    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        if ($this->userUpdated) {
            $query = <<<SQL
UPDATE dental_users 
SET 
	username = 'doc1f',
	npi = '1234567890',
	name = 'DOCTOR !',
	email = 'email1@email.com',
	address = '125 Sleepy Hollow Lane1',
	city = 'St Pete',
	state = 'CA',
	zip = '33333',
	phone = '5554443333',
	medicare_npi = '1234567890',
    tax_id_or_ssn = '8888',
	ssn = '0',
	ein = '1',
	first_name = 'Doctor',
 	last_name = '1',
	practice = 'Test Practice2',
	medicare_ptan = '123321',
	fax = '',
	mailing_practice = 'Test Practice',
	mailing_name = 'Dental Sleep Solutions',
	mailing_address = '123 Test St, Ste 205',
	mailing_city = 'St. Petersburg',
	mailing_state = 'FL',
	mailing_zip = '33704',
	mailing_phone = '5555555555',
	use_service_npi = 0,
	service_name = 'MedicareName',
	service_address = 'MedicareAddr',
	service_city = 'MedCity',
	service_state = 'MedState',
	service_zip = '99999',
	service_npi = '99999999',
	service_medicare_npi = '99999999',
	service_medicare_ptan = '88888999',
	service_tax_id_or_ssn = '99999999',
	service_ssn = 0,
	service_ein = 0,
	updated_at = '2016-01-12 15:15:29'
WHERE 
	dental_users.userid = 1;
SQL;
            $this->executeQuery($query);

            $query = <<<SQL
UPDATE dental_locations 
SET 
    location = 'South side2',
    name = 'Dental Sleep Solutions99',
    address = '123 Test St, Ste 205',
    city = 'St. Petersburg',
    state = 'FL1',
    zip = '33704',
    email = '',
    phone = '(555) 555-5555',
    fax = '(211) 111-1111'
WHERE 
	dental_locations.docid = 1;
SQL;
            $this->executeQuery($query);
        }
    }
}
