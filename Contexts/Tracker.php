<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Tracker extends BaseContext
{
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
        $rows = $this->findAllCss('div#appt_summ table > tbody > tr');
        /** @var NodeElement[] $visibleRows */
        $visibleRows = [];
        foreach ($rows as $row) {
            if ($row->getAttribute('id') && $row->isVisible()) {
                $visibleRows[] = $row;
            }
        }
        $expected = $table->getHash();
        foreach ($expected as $key => $expectedRow) {
            $inputDate = $this->findCss('td:nth-child(1) > input', $visibleRows[$key]);
            Assert::assertEquals($expectedRow['date'], $inputDate->getValue());
            Assert::assertEquals($expectedRow['name'], $this->findCss('td:nth-child(2) > span.title', $visibleRows[$key])->getText());
            $letters = $this->findCss('td:nth-child(3) > a', $visibleRows[$key])->getText();
            Assert::assertEquals($expectedRow['letters'], str_replace(' Letters', '', $letters));
            $link = $this->findCss('td:nth-child(4) > a', $visibleRows[$key]);
            if ($expectedRow['link'] == 'yes') {
                Assert::assertNotNull($link);
            } else {
                Assert::assertNull($link);
            }
        }
    }
}
