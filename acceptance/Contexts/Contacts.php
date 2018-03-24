<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class Contacts extends BaseContext
{
    /** @var int */
    private $insuranceOptionValue;

    /**
     * @When I select :option option for contact type
     *
     * @param string $option
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function selectContactType($option)
    {
        $select = $this->findCss('select#contacttypeid');
        $select->selectOption($this->insuranceOptionValue);
    }

    /**
     * @Then I see select contact type field that contains :option option
     *
     * @param string $option
     */
    public function testSelectContactTypeField($option)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $select = $this->findCss('select#contacttypeid');
        Assert::assertNotNull($select);
        $options = $this->findAllCss('option', $select);
        $hasOption = false;
        foreach ($options as $currentOption) {
            $text = $this->sanitizeText($currentOption->getText());
            if ($text == $option) {
                $hasOption = true;
                $this->insuranceOptionValue = $currentOption->getAttribute('value');
            }
        }
        Assert::assertTrue($hasOption);
    }

    /**
     * @Then I see add insurance company contact form
     */
    public function testAddInsuranceCompanyForm()
    {
        $label = $this->findCss('tr.insurance label#title0');
        Assert::assertNotNull($label);
        Assert::assertContains('Company', $label->getText());
    }
}
