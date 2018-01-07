<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class DeviceSelector extends BaseContext
{
    /**
     * @When I click on checkbox next to device selection slider :name
     *
     * @param string $name
     * @throws BehatException
     */
    public function clickOnCheckbox($name)
    {
        $headings = $this->findAllCss('form#device_form > div.setting > strong');
        $slider = null;
        foreach ($headings as $heading) {
            if ($heading->getText() == $name) {
                $slider = $heading->getParent();
                break;
            }
        }
        if (!$slider) {
            throw new BehatException("Slider $name does not exist");
        }
        $checkbox = $this->findCss('input[type="checkbox"]', $slider);
        $checkbox->click();
    }

    /**
     * @Then I see device selector modal title
     */
    public function testSeeDeviceSelectorModalTitle()
    {
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame('aj_pop');
        }

        $expectedModalTitle = 'Device C-Lect';
        $parentModalElement = $this->findCss('div#popupContact');
        $modalTitle = $this->findCss('h2', $parentModalElement)->getHtml();
        Assert::assertContains($expectedModalTitle, $modalTitle);
    }

    /**
     * @Then I see device selection sliders:
     *
     * @param TableNode $table
     */
    public function testDeviceSelectionSliders(TableNode $table)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $headings = $this->findAllCss('form#device_form > div.setting > strong');
        $labels = $this->findAllCss('form#device_form > div.setting > div.label');
        $expected = $table->getHash();
        Assert::assertEquals(sizeof($expected), sizeof($headings));
        Assert::assertEquals(sizeof($expected), sizeof($labels));
        foreach ($expected as $key => $row) {
            Assert::assertEquals($row['name'], $headings[$key]->getText());
            Assert::assertEquals($row['value'], $labels[$key]->getText());
        }
    }

    /**
     * @Then I see device selector instructions list:
     *
     * @param TableNode $table
     */
    public function testSeeInstructionsList(TableNode $table)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $instructionDiv = $this->findCss('div#instructions');
        Assert::assertTrue($instructionDiv->isVisible());
        $instructionsList = $this->findAllCss('ol > li', $instructionDiv);
        $expectedInstructionsList = array_column($table->getHash(), 'name');
        foreach ($expectedInstructionsList as $index => $instruction) {
            Assert::assertEquals($instruction, $instructionsList[$index]->getText());
        }
    }

    /**
     * @Then I do not see device selector instructions list
     */
    public function testNotSeeInstructionsList()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $instructionDiv = $this->findCss('div#instructions');
        Assert::assertFalse($instructionDiv->isVisible());
    }

    /**
     * @Then I see device list:
     *
     * @param TableNode $table
     */
    public function testDeviceList(TableNode $table)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);

        $deviceResults = $this->findAllCss('ul#results > li');
        $expectedDeviceResults = $table->getHash();
        Assert::assertEquals(sizeof($expectedDeviceResults), sizeof($deviceResults));
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
        $deviceResults = $this->findAllCss('ul#results > li > a');
        Assert::assertEmpty($deviceResults);
    }

    /**
     * @Then all checkboxes next to device selection sliders are unchecked
     */
    public function testCheckboxesUnchecked()
    {
        $checkboxes = $this->findAllCss('div.setting input[type="checkbox"]');
        Assert::assertGreaterThan(0, sizeof($checkboxes));
        foreach ($checkboxes as $checkbox) {
            Assert::assertFalse($checkbox->isChecked());
        }
    }
}
