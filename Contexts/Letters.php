<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Letters extends BaseContext
{
    /**
     * @When I click on letter number :numberOfLetter in the list
     *
     * @param string $numberOfLetter
     */
    public function clickOnLetterInList($numberOfLetter)
    {
        $childNumber = intval($numberOfLetter) + 1;
        $link = $this->findCss("table#letters-table > tbody > tr:nth-child($childNumber) > td:nth-child(2) > a");
        $link->click();
    }

    /**
     * @When I click button with text :button above page :page of letter
     *
     * @param string $button
     * @param string $page
     * @throws BehatException
     */
    public function clickButtonAbovePage($button, $page)
    {
        $index = intval($page) - 1;
        $baseDivs = $this->findAllCss('div.single-letter');
        $buttons = $this->findAllCss('button.addButton', $baseDivs[$index]);
        $submits = $this->findAllCss('input[type="submit"].addButton', $baseDivs[$index]);
        foreach ($buttons as $currentButton) {
            if ($currentButton->getText() == $button) {
                $currentButton->click();
                return;
            }
        }
        foreach ($submits as $currentButton) {
            if ($currentButton->getAttribute('value') == $button) {
                $currentButton->click();
                return;
            }
        }
        throw new BehatException('Button not found');
    }

    /**
     * @Then I see list of :numberOfLetters pending letters
     *
     * @param string $numberOfLetters
     */
    public function testListOfPendingLetters($numberOfLetters)
    {
        $heading = $this->findCss('h1.blue');
        $expected = "Pending Letters ($numberOfLetters)";
        Assert::assertEquals($expected, $heading->getText());
    }

    /**
     * @Then I see that I have :numberOfLetters letters to review
     *
     * @param string $numberOfLetters
     */
    public function testLettersToReview($numberOfLetters)
    {
        $heading = $this->findCss('div.letters-tryptych2 h2');
        $expected = "You have $numberOfLetters letters to review.";
        Assert::assertEquals($expected, $heading->getText());
    }

    /**
     * @Then I see letter data:
     *
     * @param TableNode $table
     */
    public function testLetterData(TableNode $table)
    {
        $expectedData = $table->getHash();
        $table = $this->findCss('table#letters-table');
        foreach ($expectedData as $key => $expectedRow) {
            $childNumber = $key + 2;
            $row = $this->findCss("tbody > tr:nth-child($childNumber)", $table);
            Assert::assertEquals($expectedRow['name'], $this->sanitizeText($this->findCss('td:nth-child(1)', $row)->getText()));
            Assert::assertEquals($expectedRow['correspondence'], $this->sanitizeText($this->findCss('td:nth-child(2)', $row)->getText()));
            $sentTo = str_replace('Delete', '', $this->findCss('td:nth-child(3)', $row)->getText());
            Assert::assertEquals($expectedRow['to'], $this->sanitizeText($sentTo));
            Assert::assertEquals($expectedRow['method'], $this->sanitizeText($this->findCss('td:nth-child(4)', $row)->getText()));
            Assert::assertEquals($expectedRow['date'], $this->sanitizeText($this->findCss('td:nth-child(5)', $row)->getText()));
        }
    }

    /**
     * @Then I see that the letter contains :numberOfPages pages
     *
     * @param string $numberOfPages
     */
    public function testLetterPages($numberOfPages)
    {
        $baseDivs = $this->findAllCss('div.single-letter');
        Assert::assertArrayHasKey(0, $baseDivs);
        $baseDiv = $baseDivs[0];
        Assert::assertContains("Letter 1 of $numberOfPages", $baseDiv->getText());
    }

    /**
     * @Then I see :button button above page :page of letter
     *
     * @param string $button
     * @param string $page
     */
    public function testButtonAbovePage($button, $page)
    {
        $index = intval($page) - 1;
        $baseDivs = $this->findAllCss('div.single-letter');
        Assert::assertArrayHasKey($index, $baseDivs);
        $exists = false;
        $buttons = $this->findAllCss('button.addButton', $baseDivs[$index]);
        $submits = $this->findAllCss('input[type="submit"].addButton', $baseDivs[$index]);
        foreach ($buttons as $currentButton) {
            if ($currentButton->getText() == $button) {
                $exists = true;
            }
        }
        foreach ($submits as $currentButton) {
            if ($currentButton->getAttribute('value') == $button) {
                $exists = true;
            }
        }
        Assert::assertTrue($exists);
    }

    /**
     * @Then I see that page :page of letter displays MCE editor
     *
     * @param string $page
     */
    public function testEditor($page)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $index = intval($page) - 1;
        $baseDivs = $this->findAllCss('div.single-letter');
        Assert::assertArrayHasKey($index, $baseDivs);
        $mcePanel = $this->findCss('div.mce-panel', $baseDivs[$index]);
        Assert::assertNotNull($mcePanel);
        Assert::assertTrue($mcePanel->isVisible());
    }

    /**
     * @Then I see letter preview frame
     */
    public function testLetterPreviewFrame()
    {
        // @todo: add this method when it is possible to reverse the action
    }

    /**
     * @Then I see custom letter list:
     *
     * @param TableNode $table
     */
    public function testCustomLetterList(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'name');
        $rows = $this->findAllCss('form[name="sortfrm"] > table > tbody > tr');
        foreach ($expected as $key => $name) {
            $rowKey = $key + 1;
            $cell = $this->findCss('td:nth-child(1)', $rows[$rowKey]);
            $text = $this->sanitizeText($cell->getText());
            Assert::assertEquals($name, $text);
        }
    }

    /**
     * @Then I see letter template list with :numberOfTemplates templates
     *
     * @param string $numberOfTemplates
     */
    public function testLetterTemplateList($numberOfTemplates)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $options = $this->findAllCss('select[name="template"] > option');
        Assert::assertEquals(intval($numberOfTemplates), sizeof($options));
    }
}
