<?php namespace Ds3\Libraries;

class MDReferralFilter
{
    private $num;

    function __construct($num) {
        $this->num = $num;
    }

    function isReferrer($i) {
        return $i != $this->num;
    }
}
