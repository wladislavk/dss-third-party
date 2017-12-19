<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use function PHPSTORM_META\type;
use PHPUnit\Framework\Assert;

class Support extends BaseContext
{
    const PAGERS = [
        'Open Tickets' => 'pager',
        'Closed Tickets' => 'pager2',
    ];

    const TABLES = [
        'Open Tickets' => 'sort_table',
        'Closed Tickets' => 'sort_table2',
    ];

    /**
     * @When I click on support link in top right bar
     */
    public function clickOnSupportLink()
    {
        $li = $this->findCss('li#header_support');
        $link = $this->findCss('a', $li);
        $link->click();
    }

    /**
     * @When I press button that goes to last page in :section support section
     *
     * @param string $section
     */
    public function moveToLastPage($section)
    {
        $pagerLast = $this->findCss('div#' . self::PAGERS[$section] . ' img.last');
        $pagerLast->click();
    }

    /**
     * @Then I see :section support section that contains :pages pages and I am on page :currentPage
     *
     * @param string $section
     * @param string $pages
     * @param string $currentPage
     */
    public function testSectionWithPages($section, $pages, $currentPage)
    {
        $headers = $this->findAllCss('span.admin_head');
        Assert::assertGreaterThan(0, sizeof($headers));
        $hasSection = false;
        foreach ($headers as $header) {
            if ($header->getText() == $section) {
                $hasSection = true;
            }
        }
        Assert::assertTrue($hasSection);
        $pagerInput = $this->findCss('div#' . self::PAGERS[$section] . ' input.pagedisplay');
        Assert::assertNotNull($pagerInput);
        Assert::assertEquals("$currentPage/$pages", $pagerInput->getValue());
    }

    /**
     * @Then I see the following tickets in :section support section:
     *
     * @param string $section
     * @param TableNode $table
     */
    public function testTicketsInSection($section, TableNode $table)
    {
        $ticketsTable = $this->findCss('table#' . self::TABLES[$section]);
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 1;
            $titleColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(1)", $ticketsTable);
            Assert::assertEquals($row['title'], $this->sanitizeText($titleColumn->getText()));
            $bodyColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(2)", $ticketsTable);
            Assert::assertEquals($row['body'], $this->sanitizeText($bodyColumn->getText()));
            $companyColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(3)", $ticketsTable);
            Assert::assertEquals($row['company'], $this->sanitizeText($companyColumn->getText()));
            $dateColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(4)", $ticketsTable);
            Assert::assertEquals($row['date'], $this->sanitizeText($dateColumn->getText()));
            $statusColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(5)", $ticketsTable);
            Assert::assertEquals($row['status'], $this->sanitizeText($statusColumn->getText()));
            $actionColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(6)", $ticketsTable);
            Assert::assertEquals($row['action'], $this->sanitizeText($actionColumn->getText()));
            $tr = $this->findCss("tbody > tr:nth-child($childNumber)", $ticketsTable);
            $trClass = '';
            if ($tr->getAttribute('class')) {
                $trClass = $tr->getAttribute('class');
            }
            $trBlueClass = 'unviewed';
            if ($row['background'] == 'blue') {
                Assert::assertContains($trBlueClass, $trClass);
            } else {
                Assert::assertNotContains($trBlueClass, $trClass);
            }
        }
    }

    /**
     * @Then I see add ticket form:
     *
     * @param TableNode $table
     */
    public function addTicketForm(TableNode $table)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $form = $this->findCss('form[name="contactfrm"]');
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 2;
            $column = $this->findCss("tbody > tr:nth-child($childNumber) > td", $form);
            $label = $this->findCss('label', $column);
            Assert::assertNotNull($label);
            $labelText = str_replace(':', '', $label->getText());
            Assert::assertEquals($row['field'], $this->sanitizeText($labelText));
            $valueHtml = $this->sanitizeText($column->getHtml());
            Assert::assertTrue($this->checkFormElement($column, $row['type']));
        }

        $this->getCommonClient()->switchToIFrame();
    }
}
