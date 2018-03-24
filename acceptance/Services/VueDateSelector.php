<?php

namespace Services;

use Behat\Mink\Element\NodeElement;
use Contexts\BaseContext;
use Contexts\BehatException;

class VueDateSelector
{
    // @todo: add a way to set other dates
    /**
     * @param BaseContext $context
     * @return NodeElement|null
     * @throws BehatException
     */
    public function getTodayElement(BaseContext $context)
    {
        $date = new \DateTime();
        $day = $date->format('j');
        $month = $date->format('F');
        $year = $date->format('Y');

        $firstUpDiv = $this->getUpDiv($context);
        var_dump($firstUpDiv->getText());
        $firstUpDiv->click();
        $secondUpDiv = $this->getUpDiv($context);
        $secondUpDiv->click();
        $currentDiv = $this->getCalendarDiv($context);

        $allYears = $context->findAllCss('span.year', $currentDiv);
        $yearElement = null;
        foreach ($allYears as $theYear) {
            if ($theYear->getText() == $year) {
                $yearElement = $theYear;
            }
        }
        if (!$yearElement) {
            throw new BehatException('Year not found: ' . $year);
        }
        $yearElement->click();
        $currentDiv = $this->getCalendarDiv($context);

        $allMonths = $context->findAllCss('span.month', $currentDiv);
        $monthElement = null;
        foreach ($allMonths as $theMonth) {
            if ($theMonth->getText() == $month) {
                $monthElement = $theMonth;
            }
        }
        if (!$monthElement) {
            throw new BehatException('Month not found: ' . $month);
        }
        $monthElement->click();
        $currentDiv = $this->getCalendarDiv($context);

        $allDays = $context->findAllCss('span.day', $currentDiv);
        $todayElement = null;
        foreach ($allDays as $theDay) {
            if ($theDay->getText() == $day) {
                $todayElement = $theDay;
            }
        }
        if (!$todayElement) {
            throw new BehatException('Day not found: ' . $day);
        }
        return $todayElement;
    }

    /**
     * @param BaseContext $context
     * @return NodeElement
     * @throws BehatException
     */
    private function getCalendarDiv(BaseContext $context)
    {
        $calendarDivs = $context->findAllCss('div.vdp-datepicker__calendar');
        foreach ($calendarDivs as $calendarDiv) {
            if ($calendarDiv->isVisible()) {
                return $calendarDiv;
            }
        }
        throw new BehatException('Active calendar does not exist');
    }

    /**
     * @param BaseContext $context
     * @return NodeElement
     * @throws BehatException
     */
    private function getUpDiv(BaseContext $context)
    {
        $upDivs = $context->findAllCss('span.up');
        foreach ($upDivs as $theUpDiv) {
            if ($theUpDiv->isVisible()) {
                return $theUpDiv;
            }
        }
        throw new BehatException('Up button does not exist');
    }
}
