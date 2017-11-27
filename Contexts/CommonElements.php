<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class CommonElements extends BaseContext
{
    /**
     * @Then I see right top bar with following links:
     *
     * @param TableNode $table
     */
    public function testRightTopBar(TableNode $table)
    {
        $topBar = $this->findCss('ul#topmenu2');
        $expectedLinks = array_column($table->getHash(), 'text');
        $links = $this->findAllCss('li', $topBar);
        foreach ($expectedLinks as $key => $expectedLink) {
            $realLink = trim($this->findCss('a', $links[$key])->getText());
            Assert::assertEquals($expectedLink, $realLink);
        }
    }

    /**
     * @Then I see left top bar with following links:
     *
     * @param TableNode $table
     */
    public function testLeftTopBar(TableNode $table)
    {
        $expectedLinks = array_column($table->getHash(), 'text');
        $container = $this->findCss('div.suckertreemenu2')->getParent()->getParent();
        $links = $this->findAllCss('a', $container);
        foreach ($links as $link) {
            $search = array_search($link->getText(), $expectedLinks);
            if ($search > -1) {
                unset($expectedLinks[$search]);
            }
        }
        Assert::assertEquals(0, sizeof($expectedLinks));
    }

    /**
     * @Then I see patient search form
     */
    public function testPatientSearchForm()
    {
        $tries = 3;
        $currentTry = 1;
        $input = null;
        while (!$input && $currentTry <= $tries) {
            $this->wait(self::SHORT_WAIT_TIME);
            $input = $this->findCss('input#patient_search');
            $currentTry++;
        }
        Assert::assertNotNull($input);
    }

    /**
     * @Then I see list of patients in search form:
     *
     * @param TableNode $table
     */
    public function testPatientSearchList(TableNode $table)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $list = $this->findCss('ul#patient_list');
        Assert::assertNotNull($list);
        $patients = $this->findAllCss('li.json_patient', $list);
        $expectedPatients = array_column($table->getHash(), 'name');
        Assert::assertEquals(sizeof($expectedPatients), sizeof($patients));
        foreach ($expectedPatients as $key => $expectedPatient) {
            $patient = $this->sanitizeText($patients[$key]->getText());
            Assert::assertEquals($expectedPatient, $patient);
        }
    }

    /**
     * @Then patient chart has menu with following points:
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

    /**
     * @Then I see buttons in patient search section:
     *
     * @param TableNode $table
     */
    public function testPatientSearchButtons(TableNode $table)
    {
        $patientSearchDiv = $this->findCss('div#patient_search_div');
        $parentDiv = $patientSearchDiv->getParent()->getParent();
        $buttons = $this->findAllCss('button', $parentDiv);
        $expected = array_column($table->getHash(), 'text');
        foreach ($expected as $key => $value) {
            Assert::assertEquals($value, $buttons[$key]->getText());
        }
    }
}
