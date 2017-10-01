<?php

namespace Contexts;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class ScreenerApp extends BaseContext
{
    const SCREENER_URL = 'http://' . SUT_HOST . '/screener';

    /** @var bool */
    private $formsFilled = false;

    /**
     * @When I log in as :user to screener app page
     *
     * @param string $user
     */
    public function loginAsUser($user)
    {
        $this->goToScreener();
        $password = '';
        if (array_key_exists($user, self::PASSWORDS)) {
            $password = self::PASSWORDS[$user];
        }
        $this->loginToScreener($user, $password);
    }

    /**
     * @When I visit screener app page
     */
    public function goToScreener()
    {
        $this->getCommonClient()->visit(self::SCREENER_URL);
    }

    /**
     * @When I type in :login as login and :password as password into screener app login form
     *
     * @param string $user
     * @param string $password
     */
    public function loginToScreener($user, $password)
    {
        if (!$password && array_key_exists($user, self::PASSWORDS)) {
            $password = self::PASSWORDS[$user];
        }
        $this->page->fillField('username', $user);
        $this->page->fillField('password', $password);
        $loginButton = $this->findCss('button[name="loginbut"]');
        $loginButton->click();
    }

    /**
     * @When I click screener button with text :text
     *
     * @param string $text
     * @throws BehatException
     */
    public function clickScreenerButton($text)
    {
        $currentSection = $this->getCurrentSection();
        $buttons = $this->findAllCss('a.btn', $currentSection);
        foreach ($buttons as $button) {
            if ($button->getText() == $text) {
                $this->prepareAlert();
                $button->click();
                return;
            }
        }
        throw new BehatException('Button not found');
    }

    /**
     * @When I click top screener button with text :text
     *
     * @param string $text
     * @throws BehatException
     */
    public function clickTopScreenerButton($text)
    {
        $buttons = $this->findAllCss('ul#main_nav a');
        foreach ($buttons as $button) {
            if ($this->sanitizeText($button->getText()) == $text) {
                $this->prepareAlert();
                $button->click();
                return;
            }
        }
        throw new BehatException('Button not found');
    }

    /**
     * @When I fill contact information form with data:
     *
     * @param TableNode $table
     */
    public function fillContactForm(TableNode $table)
    {
        $data = $table->getHash();
        $form = $this->findCss('form');
        foreach ($data as $key => $field) {
            $label = $this->findElementWithText('label', $field['name'], $form);
            $input = $this->findCss('input', $label->getParent());
            $input->setValue($field['value']);
        }
    }

    /**
     * @When I fill Epworth sleepiness scale form with data:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillEpworthForm(TableNode $table)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $data = $table->getHash();
        $labels = $this->findAllCss('div.dp66 > div.sepH_b > label');
        foreach ($data as $key => $select) {
            if ($labels[$key]->getText() != $select['label']) {
                throw new BehatException("Label {$select['label']} not found");
            }
            $selector = $this->findCss('select', $labels[$key]->getParent());
            $selector->selectOption($select['choice']);
        }
    }

    /**
     * @When I fill health symptoms form with data:
     *
     * @param TableNode $table
     * @param int $section
     * @throws BehatException
     */
    public function fillHealthSymptomsForm(TableNode $table, $section = 3)
    {
        $data = $table->getHash();
        $questionLabels = $this->findAllCss("div#sect$section label.question");
        foreach ($data as $key => $symptom) {
            if ($questionLabels[$key]->getText() != $symptom['label']) {
                throw new BehatException("Label {$symptom['label']} not found");
            }
            $buttonLabels = $this->findAllCss('div.buttonset > label', $questionLabels[$key]->getParent());
            $labelSelected = false;
            foreach ($buttonLabels as $buttonLabel) {
                if ($this->sanitizeText($buttonLabel->getText()) == $symptom['choice']) {
                    $buttonLabel->click();
                    $labelSelected = true;
                }
            }
            if (!$labelSelected) {
                throw new BehatException("Option {$symptom['choice']} for label {$symptom['label']} not found");
            }
        }
    }

    /**
     * @When I fill yes-no questions in previous medical diagnoses form with data:
     *
     * @param TableNode $table
     */
    public function fillPreviousDiagnosesFormYesNo(TableNode $table)
    {
        $this->fillHealthSymptomsForm($table, 4);
    }

    /**
     * @When I fill previous medical diagnoses form existing conditions checkboxes:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillPreviousDiagnosesFormCheckboxes(TableNode $table)
    {
        $data = $table->getHash();
        $checkboxLabels = $this->findAllCss('div.field > label');
        foreach ($data as $key => $element) {
            if ($checkboxLabels[$key]->getText() != $element['label']) {
                throw new BehatException("Label {$element['label']} not found");
            }
            if ($element['checked'] == 'Yes') {
                $checkbox = $this->findCss('input', $checkboxLabels[$key]->getParent());
                $checkbox->check();
            }
        }
        $this->formsFilled = true;
    }

    /**
     * @When I choose :company as company for home sleep test request
     *
     * @param string $company
     * @throws BehatException
     */
    public function chooseHSTCompany($company)
    {
        $elementDivs = $this->findAllCss('div#secthst div.sepH_b');
        $radios = $this->findAllCss('input', $elementDivs[0]);
        preg_match_all('/<input.*?>(.*?)<br/sm', $elementDivs[0]->getHtml(), $matches);
        foreach ($matches[1] as $key => $label) {
            $labelWithoutTags = strip_tags(trim($label));
            if ($labelWithoutTags == $company) {
                $radios[$key]->click();
                return;
            }
        }
        throw new BehatException("Company with label $company not found");
    }

    /**
     * @When I fill home sleep test request form with data:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillHSTForm(TableNode $table)
    {
        $expected = $table->getHash();
        $elementDivs = $this->findAllCss('div#secthst div.sepH_b');
        array_shift($elementDivs);
        foreach ($expected as $key => $element) {
            $label = $this->findCss('label', $elementDivs[$key]);
            if ($element['field'] != $label->getText()) {
                throw new BehatException("Element with label {$element['field']} not found");
            }
            $input = $this->findCss('input', $elementDivs[$key]);
            $input->setValue($element['value']);
        }
    }

    /**
     * @When I close the modal window
     */
    public function closeModalWindow()
    {
        $closeButton = $this->findCss('a#fancybox-close');
        $closeButton->click();
    }

    /**
     * @Then I see screener app login form
     */
    public function testSeeLoginForm()
    {
        Assert::assertNotNull($this->findCss('form[name="loginfrm"]'));
    }

    /**
     * @Then I see screener button with text :text
     *
     * @param string $text
     */
    public function testScreenerButton($text)
    {
        $currentSection = $this->getCurrentSection();
        $buttons = $this->findAllCss('a.btn', $currentSection);
        $exists = false;
        foreach ($buttons as $button) {
            if ($button->getText() == $text) {
                $exists = true;
            }
        }
        Assert::assertTrue($exists);
    }

    /**
     * @Then I see top screener button with text :text
     *
     * @param string $text
     */
    public function testTopScreenerButton($text)
    {
        $buttons = $this->findAllCss('ul#main_nav a');
        $exists = false;
        foreach ($buttons as $button) {
            if ($this->sanitizeText($button->getText()) == $text) {
                $exists = true;
            }
        }
        Assert::assertTrue($exists);
    }

    /**
     * @When I see screener left header :text
     *
     * @param string $text
     */
    public function testScreenerLeftHeader($text)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $currentSection = $this->getCurrentSection();
        $header = $this->findCss('h3', $currentSection);
        Assert::assertEquals($text, $header->getText());
    }

    /**
     * @Then I see screener right header :text
     *
     * @param string $text
     */
    public function testScreenerRightHeader($text)
    {
        $currentSection = $this->getCurrentSection();
        $header = $this->findCss('h5', $currentSection);
        Assert::assertEquals($text, $this->sanitizeText($header->getText()));
    }

    /**
     * @Then I see contact information form with fields:
     *
     * @param TableNode $table
     */
    public function testContactInformationForm(TableNode $table)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $expected = array_column($table->getHash(), 'name');
        $form = $this->findCss('form');
        $elements = $this->findAllCss('div.sepH_b', $form);
        foreach ($expected as $key => $expectedName) {
            $label = $this->findCss('label', $elements[$key]);
            Assert::assertEquals($expectedName, $label->getText());
        }
    }

    /**
     * @Then I see Epworth sleepiness scale form with questions:
     *
     * @param TableNode $table
     */
    public function testEpworthForm(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'name');
        $elements = $this->findAllCss('div.dp66 > div.sepH_b');
        foreach ($expected as $key => $name) {
            $label = $this->findCss('label', $elements[$key]);
            Assert::assertEquals($name, $label->getText());
        }
    }

    /**
     * @Then each question in Epworth sleepiness scale form has following options:
     *
     * @param TableNode $table
     */
    public function testEpworthFormChoices(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'option');
        $firstElementOptions = $this->findAllCss('div.dp66 > div.sepH_b > select > option');
        foreach ($expected as $key => $option) {
            $optionKey = $key + 1;
            Assert::assertEquals($option, $firstElementOptions[$optionKey]->getText());
        }
    }

    /**
     * @Then I see health symptoms form with questions:
     *
     * @param TableNode $table
     * @param int $section
     */
    public function testHealthSymptomsForm(TableNode $table, $section = 3)
    {
        $labels = $this->findAllCss("div#sect$section label.question");
        $expected = array_column($table->getHash(), 'label');
        foreach ($expected as $key => $label) {
            Assert::assertEquals($label, $labels[$key]->getText());
        }
    }

    /**
     * @Then each question in health symptoms form has following options:
     *
     * @param TableNode $table
     */
    public function testHealthSymptomsFormOptions(TableNode $table)
    {
        $firstButtonSet = $this->findCss('div.buttonset');
        $labels = $this->findAllCss('label', $firstButtonSet);
        $expected = array_column($table->getHash(), 'option');
        foreach ($expected as $key => $label) {
            Assert::assertEquals($label, $this->sanitizeText($labels[$key]->getText()));
        }
    }

    /**
     * @Then previous medical diagnoses form contains yes-no questions:
     *
     * @param TableNode $table
     */
    public function testPreviousDiagnosesFormYesNo(TableNode $table)
    {
        $this->testHealthSymptomsForm($table, 4);
    }

    /**
     * @Then previous medical diagnoses form contains checkboxes for existing conditions:
     *
     * @param TableNode $table
     */
    public function testPreviousDiagnosesFormCheckboxes(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'label');
        $checkboxLabels = $this->findAllCss('div.field > label');
        foreach ($expected as $key => $label) {
            Assert::assertEquals($label, $checkboxLabels[$key]->getText());
        }
    }

    /**
     * @Then I see screener result with risk level :level
     *
     * @param string $level
     */
    public function testScreenerResultRisk($level)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $string = strtolower($level) . ' risk';
        $risks = $this->findAllCss('div.risk_desc');
        foreach ($risks as $risk) {
            if ($risk->isVisible()) {
                Assert::assertContains($string, $risk->getText());
                return;
            }
        }
        Assert::assertTrue(false);
    }

    /**
     * @Then I see arrow image with risk level :level
     *
     * @param string $level
     */
    public function testArrowImage($level)
    {
        $name = strtolower($level) . '_risk';
        $images = $this->findAllCss('img');
        $found = false;
        foreach ($images as $image) {
            if ($image->isVisible() && strstr($image->getAttribute('src'), $name)) {
                $found = true;
            }
        }
        Assert::assertTrue($found);
    }

    /**
     * @Then I see :section screener results section with data:
     *
     * @param string $section
     * @param TableNode $table
     */
    public function testScreenerResults($section, TableNode $table)
    {
        $sections = [
            'left' => 0,
            'right' => 1,
        ];
        Assert::assertArrayHasKey($section, $sections);
        $results = $this->findAllCss('div#results_div > div');
        $sectionContents = $results[$sections[$section]];
        $rows = $this->findAllCss('div', $sectionContents);
        array_shift($rows);
        foreach ($rows as $rowKey => $row) {
            if (!$row->isVisible()) {
                unset($rows[$rowKey]);
            }
        }
        /** @var NodeElement[] $rows */
        $rows = array_values($rows);
        $expectedRows = array_column($table->getHash(), 'row');
        $listContents = [];
        $lastKey = 0;
        foreach ($rows as $key => $row) {
            $rowText = $this->sanitizeText($row->getText());
            $diagnosedList = $this->findCss('ul#r_diagnosed', $row);
            if ($diagnosedList) {
                $label = $this->findCss('label', $row);
                $rowText = $label->getText();
                $listContents = $this->findAllCss('li', $diagnosedList);
            }
            Assert::assertEquals($expectedRows[$key], $rowText);
            $lastKey = $key;
        }
        foreach ($listContents as $listKey => $listContent) {
            $expectedRowKey = $lastKey + $listKey + 1;
            Assert::assertEquals($expectedRows[$expectedRowKey], $listContent->getText());
        }
    }

    /**
     * @Then I see a modal window with heading :heading
     *
     * @param string $heading
     */
    public function testSeeModalWindow($heading)
    {
        $modalContent = $this->findCss('div#fancybox-content');
        Assert::assertNotNull($modalContent);
        Assert::assertTrue($modalContent->isVisible());
        $modalHeading = $this->findCss('h4', $modalContent);
        Assert::assertEquals($heading, $modalHeading->getText());
    }

    /**
     * @Then I see company list in home sleep test request form:
     *
     * @param TableNode $table
     */
    public function testHSTCompanyList(TableNode $table)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $elementDivs = $this->findAllCss('div#secthst div.sepH_b');
        $companyDiv = $elementDivs[0];
        $companyDivContent = str_replace('<label class="lbl_a">HST Company</label>', '', $companyDiv->getHtml());
        $expected = array_column($table->getHash(), 'company');
        foreach ($expected as $company) {
            Assert::assertContains($company, $companyDivContent);
        }
    }

    /**
     * @Then I see home sleep test request form pre-populated with data:
     *
     * @param TableNode $table
     */
    public function testHSTForm(TableNode $table)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $expected = $table->getHash();
        $elementDivs = $this->findAllCss('div#secthst div.sepH_b');
        array_shift($elementDivs);
        foreach ($expected as $key => $element) {
            $label = $this->findCss('label', $elementDivs[$key]);
            Assert::assertEquals($element['field'], $label->getText());
            $input = $this->findCss('input', $elementDivs[$key]);
            Assert::assertNotNull($input);
            Assert::assertEquals($element['value'], $input->getValue());
        }
    }

    /**
     * @AfterScenario
     *
     * @param AfterScenarioScope $scope
     */
    public function afterScenario(AfterScenarioScope $scope)
    {
        if ($this->formsFilled) {
            $query = <<<SQL
DELETE FROM dental_screener_epworth
WHERE screener_id IN
(SELECT id FROM dental_screener WHERE first_name='John' AND last_name='Dowson')
SQL;
            $this->executeQuery($query);
            $query = <<<SQL
DELETE FROM dental_hst_epworth
WHERE hst_id IN
  (SELECT h.id FROM dental_hst h JOIN dental_screener s ON h.screener_id=s.id WHERE s.first_name='John' AND s.last_name='Dowson')
SQL;
            $this->executeQuery($query);
            $query = <<<SQL
DELETE FROM dental_hst
WHERE screener_id IN
(SELECT id FROM dental_screener WHERE first_name='John' AND last_name='Dowson')
SQL;
            $this->executeQuery($query);
            $query = <<<SQL
DELETE FROM dental_screener WHERE first_name='John' AND last_name='Dowson'
SQL;
            $this->executeQuery($query);
        }
    }

    /**
     * @return NodeElement
     * @throws BehatException
     */
    private function getCurrentSection()
    {
        $sections = $this->findAllCss('div.sect');
        foreach ($sections as $section) {
            if ($section->isVisible()) {
                return $section;
            }
        }
        throw new BehatException('Current section not found');
    }
}
