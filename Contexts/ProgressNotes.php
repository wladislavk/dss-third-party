<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class ProgressNotes extends BaseContext
{
    /**
     * @When I select :template in text templates select list
     *
     * @param string $template
     * @throws BehatException
     */
    public function selectTemplateInList($template)
    {
        $select = $this->findCss('select[name="title"]');
        $options = $this->findAllCss('option', $select);
        foreach ($options as $option) {
            if ($this->sanitizeText($option->getText()) == $template) {
                $select->selectOption($option->getValue());
                return;
            }
        }
        throw new BehatException("Option with text $template not found");
    }

    /**
     * @Then I see progress note frame for patient :patient
     *
     * @param string $patient
     */
    public function testProgressNoteFrameForPatient($patient)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');
        $cell = $this->findCss('td.cat_head');
        Assert::assertContains("Patient $patient", $this->sanitizeText($cell->getText()));
    }

    /**
     * @Then I see text templates select list
     */
    public function testTextTemplatesSelectList()
    {
        $select = $this->findCss('select[name="title"]');
        Assert::assertNotNull($select);
    }

    /**
     * @Then the main progress note text field contains text :text
     *
     * @param string $text
     */
    public function testMainTextField($text)
    {
        $textarea = $this->findCss('textarea#notes');
        Assert::assertEquals($text, $textarea->getValue());
    }

    /**
     * @Then the main progress note text field is empty
     */
    public function testMainTextFieldEmpty()
    {
        $textarea = $this->findCss('textarea#notes');
        Assert::assertEquals('', $textarea->getValue());
    }
}
