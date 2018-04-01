<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\FlowsheetStepRepository;
use DentalSleepSolutions\Helpers\TrackerStepRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class TrackerStepRetrieverTest extends UnitTestCase
{
    /** @var array */
    private $steps = [];

    /** @var array */
    private $ranks = [
        [
            'id' => 2,
            'rank' => 20,
        ],
        [
            'id' => 4,
            'rank' => 21,
        ],
    ];

    /** @var TrackerStepRetriever */
    private $trackerStepRetriever;

    public function setUp()
    {
        $appointmentSummaryRepository = $this->mockAppointmentSummaryRepository();
        $flowsheetStepRepository = $this->mockFlowsheetStepRepository();
        $this->trackerStepRetriever = new TrackerStepRetriever($appointmentSummaryRepository, $flowsheetStepRepository);
    }

    public function testGetRanksBySection()
    {
        $result = $this->trackerStepRetriever->getRanksBySection();
        $expected = [
            'first' => [1],
            'second' => [2],
        ];
        $this->assertEquals($expected, $result);
    }

    public function testGetFinalRankForFirstSection()
    {
        $this->steps = [
            [
                'section' => 1,
                'segmentid' => 2,
                'sort_by' => 5,
            ],
            [
                'section' => 2,
                'segmentid' => 3,
                'sort_by' => 7,
            ],
            [
                'section' => 1,
                'segmentid' => 4,
                'sort_by' => 6,
            ],
        ];
        $patientId = 12;
        $result = $this->trackerStepRetriever->getFinalRank($patientId);
        $expected = [
            'last_segment' => 2,
            'final_segment' => 4,
            'final_rank' => 21,
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    public function testGetFinalRankForSecondSection()
    {
        $this->steps = [
            [
                'section' => 2,
                'segmentid' => 2,
                'sort_by' => 5,
            ],
            [
                'section' => 2,
                'segmentid' => 3,
                'sort_by' => 7,
            ],
            [
                'section' => 1,
                'segmentid' => 4,
                'sort_by' => 6,
            ],
        ];
        $patientId = 12;
        $result = $this->trackerStepRetriever->getFinalRank($patientId);
        $expected = [
            'last_segment' => 2,
            'final_segment' => 3,
            'final_rank' => 0,
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    public function testWithoutSteps()
    {
        $patientId = 12;
        $result = $this->trackerStepRetriever->getFinalRank($patientId);
        $expected = [
            'last_segment' => 0,
            'final_segment' => 0,
            'final_rank' => 0,
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    private function mockAppointmentSummaryRepository()
    {
        /** @var AppointmentSummaryRepository|MockInterface $appointmentSummaryRepository */
        $appointmentSummaryRepository = \Mockery::mock(AppointmentSummaryRepository::class);
        $appointmentSummaryRepository->shouldReceive('getLastTrackerStep')->andReturnUsing(function () {
            return $this->steps;
        });
        return $appointmentSummaryRepository;
    }

    private function mockFlowsheetStepRepository()
    {
        /** @var FlowsheetStepRepository|MockInterface $flowsheetStepRepository */
        $flowsheetStepRepository = \Mockery::mock(FlowsheetStepRepository::class);
        $flowsheetStepRepository->shouldReceive('getStepsByRank')->andReturnUsing(function ($section = 0) {
            if ($section) {
                return [$section];
            }
            return $this->ranks;
        });
        return $flowsheetStepRepository;
    }
}
