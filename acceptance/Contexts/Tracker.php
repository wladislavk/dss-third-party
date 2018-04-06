<?php
namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Tracker extends BaseContext
{
    /** @var bool */
    private $studyTypeAdded = false;

    /** @var bool */
    private $deliveryAdded = false;

    /** @var bool */
    private $impressionDeleted = false;

    /** @var bool */
    private $treatmentCompleteAdded = false;

    /** @var bool */
    private $baselineTestAdded = false;

    /** @var bool */
    private $delayReasonAdded = false;

    /** @var bool */
    private $nonCompliancyReasonAdded = false;

    /**
     * @When I click on :point in today tracker section
     *
     * @param string $point
     * @throws BehatException
     */
    public function clickOnFirstSection($point)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $parent = $this->findCss('div#treatment_list');
        Assert::assertNotNull($parent);
        $firstList = $this->findAllCss('ul.sect1 > li', $parent);
        $secondList = $this->findAllCss('ul.sect2 > li', $parent);
        foreach ($firstList as $element) {
            $link = $this->findCss('a', $element);
            if (!$link) {
                continue;
            }
            if ($link->getText() == $point) {
                $link->click();
                if ($point == 'Titration Sleep Study') {
                    $this->studyTypeAdded = true;
                }
                if ($point == 'Device Delivery') {
                    $this->deliveryAdded = true;
                }
                if ($point == 'Treatment Complete') {
                    $this->treatmentCompleteAdded = true;
                }
                if ($point == 'Baseline Sleep Test') {
                    $this->baselineTestAdded = true;
                }
                return;
            }
        }
        foreach ($secondList as $element) {
            $link = $this->findCss('a', $element);
            if (!$link) {
                continue;
            }
            if ($link->getText() == $point) {
                $link->click();
                if ($point == 'Delaying Tx/Waiting') {
                    $this->delayReasonAdded = true;
                }
                if ($point == 'Pt. Non-compliant') {
                    $this->nonCompliancyReasonAdded = true;
                }
                return;
            }
        }
        throw new BehatException("Link with text $point not found");
    }

    /**
     * @When I choose :type as modal type
     *
     * @param string $type
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function chooseModalType($type)
    {
        $select = $this->findCss('select');
        $select->selectOption($type);
    }

    /**
     * @When I change treatment summary row :type to :value
     *
     * @param string $type
     * @param string $value
     * @throws BehatException
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function changeSummarySelector($type, $value)
    {
        $rows = $this->findAllCss('div#appt_summ table tr');
        foreach ($rows as $row) {
            $rowName = $this->findCss('td:nth-child(2) > span.title', $row);
            if (!$rowName) {
                continue;
            }
            // @todo: happens because of quirk in legacy, remove next two lines after migration
            $rowNameText = str_replace('Titration Sleep Study', 'Sleep Study', $rowName->getText());
            $type = str_replace('Titration Sleep Study', 'Sleep Study', $type);
            if ($rowNameText != $type) {
                continue;
            }
            $select = $this->findCss('td:nth-child(2) select', $row);
            if (!$select) {
                break;
            }
            $select->selectOption($value);
            return;
        }
        throw new BehatException("Row with name $type not found or does not have selector");
    }

    /**
     * @When I change date on treatment summary row :type to :date
     *
     * @param string $type
     * @param string $date
     * @throws BehatException
     */
    public function changeSummaryDate($type, $date)
    {
        $rows = $this->findAllCss('div#appt_summ table > tbody > tr');
        foreach ($rows as $row) {
            $rowName = $this->findCss('td:nth-child(2) > span.title', $row);
            if (!$rowName || $rowName->getText() != $type) {
                continue;
            }
            $rowDate = $this->findCss('td:nth-child(1) > input');
            if (!$rowDate) {
                break;
            }
            $rowDate->click();
            if (SUT_HOST == 'vue') {
                //$vueDateSelector = new VueDateSelector();
                //$todayDiv = $vueDateSelector->getTodayElement($this);
            } else {
                if ($date == 'today') {
                    $this->wait(self::SHORT_WAIT_TIME);
                    $todayDiv = $this->findCss('div.DynarchCalendar-bottomBar-today');
                    $todayDiv->click();
                }
            }
            return;
        }
        throw new BehatException("Row with name $type not found");
    }

    /**
     * @When I click delete button next to treatment summary row :type
     *
     * @param string $type
     * @throws BehatException
     */
    public function deleteSummaryStep($type)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $rows = $this->findAllCss('div#appt_summ table tr');
        foreach ($rows as $row) {
            $rowName = $this->findCss('td:nth-child(2) > span.title', $row);
            if (!$rowName) {
                continue;
            }
            // @todo: happens because of quirk in legacy, remove next two lines after migration
            $rowNameText = str_replace('Titration Sleep Study', 'Sleep Study', $rowName->getText());
            $type = str_replace('Titration Sleep Study', 'Sleep Study', $type);
            if ($rowNameText != $type) {
                continue;
            }
            $deleteButton = $this->findCss('td:nth-child(4) > a', $row);
            if (!$deleteButton) {
                break;
            }
            $deleteButton->click();
            if ($type == 'Impressions') {
                $this->impressionDeleted = true;
            }
            return;
        }
        throw new BehatException("Row with name $type not found or does not have delete button");
    }

    /**
     * @When I add text :text in modal text area
     *
     * @param string $text
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     * @throws BehatException
     */
    public function fillModalTextArea($text)
    {
        $textarea = $this->findCss('textarea');
        if (!$textarea) {
            throw new BehatException('Text area is not present in the modal');
        }
        $this->page->fillField($textarea->getAttribute('name'), $text);
    }

    /**
     * @When I click link with text :text below :row row in treatment summary tracker section
     *
     * @param string $text
     * @param string $row
     * @throws BehatException
     */
    public function clickLinkBelowRow($text, $row)
    {
        $summaryRow = $this->getSummaryRow($row);
        if (!$summaryRow) {
            throw new BehatException("Summary row with header $row does not exist");
        }
        $link = $this->findCss('a', $summaryRow);
        if (!$link || $link->getText() != $text) {
            throw new BehatException("Link with text $link does not exist");
        }
        $link->click();
    }

    /**
     * @Then I see top right patient buttons:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function testTopRightButtons(TableNode $table)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $calendarLink = $this->findElementWithText('a', 'View Calendar Appts');
        $buttonDiv = $calendarLink->getParent();
        $buttons = array_column($table->getHash(), 'name');
        // current HTML orders buttons from right to left
        $buttons = array_reverse($buttons);
        $buttonLinks = $this->findAllCss('a', $buttonDiv);
        Assert::assertEquals(sizeof($buttons), sizeof($buttonLinks));
        foreach ($buttons as $key => $text) {
            Assert::assertEquals($text, $buttonLinks[$key]->getText());
        }
    }

    /**
     * @Then today tracker section has a list of treatments:
     *
     * @param TableNode $table
     */
    public function testTodayTrackerSection(TableNode $table)
    {
        $parent = $this->findCss('div#treatment_list');
        Assert::assertNotNull($parent);
        $expected = $table->getHash();
        $expectedFirst = [];
        $expectedSecond = [];
        foreach ($expected as $element) {
            switch ($element['color']) {
                case 'blue':
                    // fall through
                case 'white':
                    $expectedFirst[] = $element;
                    break;
                case 'grey':
                    $expectedSecond[] = $element;
                    break;
            }
        }
        $firstList = $this->findAllCss('ul.sect1 > li', $parent);
        $secondList = $this->findAllCss('ul.sect2 > li', $parent);
        foreach ($expectedFirst as $key => $element) {
            $classExists = false;
            $class = $firstList[$key]->getAttribute('class');
            if ($class == 'completed_step' || $class == 'last') {
                $classExists = true;
            }
            if ($element['color'] == 'blue') {
                Assert::assertTrue($classExists);
            } else {
                Assert::assertFalse($classExists);
            }
            $link = $this->findCss('a', $firstList[$key]);
            if ($element['link'] == 'yes') {
                Assert::assertNotNull($link);
                Assert::assertEquals($element['name'], $link->getText());
            } else {
                Assert::assertNull($link);
                Assert::assertEquals($element['name'], $firstList[$key]->getText());
            }
        }
        foreach ($expectedSecond as $key => $element) {
            $link = $this->findCss('a', $secondList[$key]);
            if ($element['link'] == 'yes') {
                Assert::assertNotNull($link);
                Assert::assertEquals($element['name'], $link->getText());
            } else {
                Assert::assertNull($link);
                Assert::assertEquals($element['name'], $secondList[$key]->getText());
            }
        }
    }

    /**
     * @Then treatment summary tracker section has the list of treatments:
     *
     * @param TableNode $table
     */
    public function testTreatmentSummarySection(TableNode $table)
    {
        $this->getCommonClient()->switchToIFrame();
        $this->wait(self::SHORT_WAIT_TIME);
        $rows = $this->findAllCss('div#appt_summ tr');
        /** @var NodeElement[] $visibleRows */
        $visibleRows = [];
        foreach ($rows as $row) {
            if ($row->getAttribute('id') && $row->getAttribute('id') != 'completed_row_temp' && $row->isVisible()) {
                $visibleRows[] = $row;
            }
        }
        $expected = $table->getHash();
        $today = (new \DateTime())->format('m/d/Y');
        Assert::assertEquals(sizeof($expected), sizeof($visibleRows));
        foreach ($expected as $key => $expectedRow) {
            $expectedDate = $expectedRow['date'];
            if ($expectedDate == 'today') {
                $expectedDate = $today;
            }
            $inputDate = $this->findCss('td:nth-child(1) input', $visibleRows[$key]);
            Assert::assertEquals($expectedDate, $inputDate->getValue());
            $rowName = $this->findCss('td:nth-child(2) > span.title', $visibleRows[$key])->getText();
            // @todo: happens because of quirk in legacy, remove next two lines after migration
            $rowName = str_replace('Titration Sleep Study', 'Sleep Study', $rowName);
            $expectedRowName = str_replace('Titration Sleep Study', 'Sleep Study', $expectedRow['name']);
            Assert::assertEquals($expectedRowName, $rowName);
            $select = $this->findCss('td:nth-child(2) select', $visibleRows[$key]);
            if ($expectedRow['selected']) {
                Assert::assertNotNull($select);
                $options = $this->findAllCss('option', $select);
                $selected = '';
                foreach ($options as $option) {
                    if ($option->getAttribute('value') == $select->getValue()) {
                        $selected = $option->getText();
                    }
                }
                Assert::assertEquals($expectedRow['selected'], $selected);
            } else {
                Assert::assertNull($select);
            }
            $letters = $this->findCss('td:nth-child(3)', $visibleRows[$key])->getText();
            Assert::assertEquals($expectedRow['letters'], str_replace(' Letters', '', $letters));
            $link = $this->findCss('td:nth-child(4) > a', $visibleRows[$key]);
            if ($expectedRow['link'] == 'yes') {
                Assert::assertNotNull($link);
            } else {
                Assert::assertNull($link);
            }
        }
    }

    /**
     * @Then next steps tracker section has the list of steps:
     *
     * @param TableNode $table
     */
    public function testNextStepsSection(TableNode $table)
    {
        $expectedSteps = array_column($table->getHash(), 'name');
        $options = $this->findAllCss('select#next_step > option');
        Assert::assertEquals(sizeof($expectedSteps), sizeof($options));
        foreach ($expectedSteps as $key => $step) {
            Assert::assertEquals($step, $options[$key]->getText());
        }
    }

    /**
     * @Then treatment summary row :subListRow has a sub-select list:
     *
     * @param string $subListRow
     * @param TableNode $table
     */
    public function testTreatmentSummarySubList($subListRow, TableNode $table)
    {
        $summaryRow = $this->getSummaryRow($subListRow);
        Assert::assertNotNull($summaryRow);
        $options = $this->findAllCss('select > option', $summaryRow);
        $expected = array_column($table->getHash(), 'name');
        Assert::assertEquals(sizeof($expected), sizeof($options));
        // order of elements cannot be guaranteed
        $optionValues = [];
        foreach ($options as $option) {
            $optionValues[] = $option->getText();
        }
        foreach ($expected as $value) {
            Assert::assertTrue(in_array($value, $optionValues));
        }
    }

    /**
     * @Then I see a modal list:
     *
     * @param TableNode $table
     */
    public function testModalList(TableNode $table)
    {
        $options = $this->findAllCss('form > select > option');
        $expected = array_column($table->getHash(), 'name');
        Assert::assertEquals(sizeof($expected), sizeof($options));
        $optionTexts = [];
        foreach ($options as $option) {
            $optionTexts[] = $option->getText();
        }
        foreach ($expected as $key => $value) {
            // @todo: order cannot be guaranteed, change after migration is complete
            // Assert::assertEquals($value, $options[$key]->getText());
            Assert::assertTrue(in_array($value, $optionTexts));
        }
    }

    /**
     * @Then I see link with text :text below :row row in treatment summary tracker section
     *
     * @param string $text
     * @param string $row
     */
    public function testLinkBelowRow($text, $row)
    {
        $summaryRow = $this->getSummaryRow($row);
        Assert::assertNotNull($summaryRow);
        $link = $this->findCss('a', $summaryRow);
        Assert::assertNotNull($link);
        Assert::assertTrue($link->isVisible());
        Assert::assertEquals($text, $link->getText());
    }

    /**
     * @Then I do not see links below :row row in treatment summary tracker section
     *
     * @param string $row
     */
    public function testNoLinkBelowRow($row)
    {
        $summaryRow = $this->getSummaryRow($row);
        Assert::assertNotNull($summaryRow);
        $link = $this->findCss('a', $summaryRow);
        $exists = false;
        if ($link && $link->isVisible()) {
            $exists = true;
        }
        Assert::assertFalse($exists);
    }

    /**
     * @Then I see text :text in modal text area
     *
     * @param string $text
     */
    public function testModalTextArea($text)
    {
        $textarea = $this->findCss('textarea');
        Assert::assertNotNull($textarea);
        Assert::assertEquals($text, $textarea->getValue());
    }

    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        if ($this->studyTypeAdded) {
            $query = <<<SQL
DELETE FROM dental_flow_pg2_info WHERE patientid=170 AND segmentid=3;
SQL;
            $this->executeQuery($query);
        }
        if ($this->deliveryAdded) {
            $query = <<<SQL
DELETE FROM dental_flow_pg2_info WHERE patientid=170 AND segmentid=7;
SQL;
            $this->executeQuery($query);
        }
        if ($this->impressionDeleted) {
            $query = <<<SQL
INSERT INTO dental_flow_pg2_info (patientid, segmentid, date_completed, appointment_type, device_id) 
VALUES (170, 4, '2015-03-27', 1, 2);
SQL;
            $this->executeQuery($query);
        }
        if ($this->treatmentCompleteAdded) {
            $query = <<<SQL
DELETE FROM dental_flow_pg2_info WHERE patientid=170 AND segmentid=11;
SQL;
            $this->executeQuery($query);
        }
        if ($this->baselineTestAdded) {
            $query = <<<SQL
DELETE FROM dental_flow_pg2_info WHERE patientid=170 AND segmentid=15;
SQL;
            $this->executeQuery($query);
        }
        if ($this->delayReasonAdded) {
            $query = <<<SQL
DELETE FROM dental_flow_pg2_info WHERE patientid=170 AND segmentid=5;
SQL;
            $this->executeQuery($query);
        }
        if ($this->nonCompliancyReasonAdded) {
            $query = <<<SQL
DELETE FROM dental_flow_pg2_info WHERE patientid=170 AND segmentid=9;
SQL;
            $this->executeQuery($query);
        }
    }

    /**
     * @param string $text
     * @return NodeElement|null
     */
    private function getSummaryRow($text)
    {
        $rows = $this->findAllCss('div#appt_summ table tr');
        /** @var NodeElement[] $visibleRows */
        foreach ($rows as $row) {
            $rowTitle = $this->findCss('td:nth-child(2) > span.title', $row);
            if ($rowTitle) {
                // @todo: happens because of quirk in legacy, remove next two lines after migration
                $rowTitleText = str_replace('Titration Sleep Study', 'Sleep Study', $rowTitle->getText());
                $text = str_replace('Titration Sleep Study', 'Sleep Study', $text);
                if ($rowTitleText == $text) {
                    return $rowTitle->getParent();
                }
            }
        }
        return null;
    }
}
