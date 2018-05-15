<?php

namespace Tests\Unit\Services\Letters;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Services\Letters\LettersQueryComposer;
use Tests\TestCases\QueryComposerTestCase;

class LettersQueryComposerTest extends QueryComposerTestCase
{
    /** @var LettersQueryComposer */
    private $lettersQueryComposer;

    public function setUp()
    {
        $methods = [
            'getUpdateLetterBaseQuery',
            'getUpdateLetterCondition',
            'doUpdateLetter',
        ];
        /** @var LetterRepository $repository */
        $repository = $this->mockRepository(LetterRepository::class, $methods);
        $this->lettersQueryComposer = new LettersQueryComposer($repository);
    }

    public function testUpdateLetterBy()
    {
        $where = [
            'first' => 1,
            'second' => 2,
        ];
        $updateData = ['foo' => 'bar'];
        $this->lettersQueryComposer->updateLetterBy($where, $updateData);

        $expected = [
            LetterRepository::class => [
                'getUpdateLetterBaseQuery' => [
                    [],
                ],
                'getUpdateLetterCondition' => [
                    ['first', 1],
                    ['second', 2],
                ],
                'doUpdateLetter' => [
                    [
                        ['foo' => 'bar'],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $this->repositories);
    }
}
