<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class DeviceSelector extends BaseContext
{
    /**
     * @Then I see device selection sliders:
     *
     * @param TableNode $table
     */
    public function testDeviceSelectionSliders(TableNode $table)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $headings = $this->findAllCss('form#device_form > div.setting > strong');
        $expected = array_column($table->getHash(), 'name');
        foreach ($expected as $key => $name) {
            Assert::assertEquals($name, $headings[$key]->getText());
        }
    }

    /**
     * @Then I see device list:
     *
     * @param TableNode $table
     */
    public function testDeviceList(TableNode $table)
    {
        $results = $this->findAllCss('ul#results > li > a');
        $expected = $table->getHash();
        foreach ($expected as $key => $row) {
            $expectedName = "{$row['name']} ({$row['quantity']})";
            Assert::assertEquals($expectedName, $results[$key]->getText());
        }
    }
}
