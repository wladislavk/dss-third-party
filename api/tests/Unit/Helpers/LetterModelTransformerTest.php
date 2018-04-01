<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Helpers\LetterModelTransformer;
use Tests\TestCases\UnitTestCase;

class LetterModelTransformerTest extends UnitTestCase
{
    /** @var LetterModelTransformer */
    private $letterModelTransformer;

    public function setUp()
    {
        $this->letterModelTransformer = new LetterModelTransformer();
    }

    public function testTransformLetters()
    {
        $firstLetter = new Letter();
        $firstLetter->letterid = 1;
        $firstLetter->md_list = '1';
        $firstLetter->md_referral_list = '2,3';
        $secondLetter = new Letter();
        $secondLetter->letterid = 2;
        $transformed = $this->letterModelTransformer->transformLetters([$firstLetter, $secondLetter]);
        $this->assertEquals(2, sizeof($transformed));
        $first = $transformed[0];
        $this->assertEquals(1, $first['letterid']);
        $this->assertEquals([1], $first['md_list']);
        $this->assertEquals([2, 3], $first['md_referral_list']);
        $this->assertEquals([], $first['cc_md_list']);
        $second = $transformed[1];
        $this->assertEquals(2, $second['letterid']);
    }
}
