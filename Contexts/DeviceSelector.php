<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class DeviceSelector extends BaseContext
{
    /**
     * @Then I see device selector modal title
     */
    public function testSeeDeviceSelectorModalTitle()
    {
        $expectedModalTitle = 'Device C-Lect for  ?';
        $parentModalElement = $this->findCss('div#popupContact');
        $modalTitle = $this->findCss('h2', $parentModalElement)->getHtml();
        Assert::assertEquals($expectedModalTitle, $modalTitle);
    }

    /**
     * @Then I see device selection sliders:
     *
     * @param TableNode $table
     */
    public function testDeviceSelectionSliders(TableNode $table)
    {
        if (SUT_HOST === 'vue') {
            $this->wait(self::SHORT_WAIT_TIME);
        }

        $headings = $this->findAllCss('form#device_form > div.setting > strong');
        $expected = array_column($table->getHash(), 'name');
        foreach ($expected as $key => $name) {
            Assert::assertEquals($name, $headings[$key]->getHtml());
        }
    }

    /**
     * @Then I see device selector instructions list:
     *
     * @param TableNode $table
     */
    public function testSeeInstructionsList(TableNode $table)
    {
        $instructionsList = $this->findAllCss('div#instructions > ol > li');
        $expectedInstructionsList = array_column($table->getHash(), 'name');
        foreach ($expectedInstructionsList as $index => $instruction) {
            Assert::assertEquals($instruction, $instructionsList[$index]->getText());
        }
    }

    /**
     * @Then I see device list:
     *
     * @param TableNode $table
     */
    public function testDeviceList(TableNode $table)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);

        $deviceResults = $this->findAllCss($this->getDeviceNameLinkCss());
        $expectedDeviceResults = $table->getHash();
        foreach ($expectedDeviceResults as $index => $row) {
            $expectedName = "{$row['name']} ({$row['quantity']})";
            Assert::assertEquals($expectedName, $deviceResults[$index]->getText());
        }
    }

    /**
     * @Then I don't see device list
     */
    public function testNotSeeDeviceList()
    {
        $deviceResults = $this->findAllCss($this->getDeviceNameLinkCss());
        Assert::assertEmpty($deviceResults);
    }

    /**
     * @return string
     */
    private function getDeviceNameLinkCss()
    {
        $deviceNameLinkCss = 'ul#results > li > a';
        if (SUT_HOST === 'vue') {
            $deviceNameLinkCss = 'div#device-results-div > ul > li > a';
        }

        return $deviceNameLinkCss;
    }
}
