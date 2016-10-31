<?php

namespace Deejff\RangeGenerator;

use Deejff\RangeGenerator\RangeByTypeGenerator;

class RangeByTypeGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RangeByTypeGenerator
     */
    private $rangeByTypeGeneratorService;
    private $startDate;

    protected function setUp()
    {
        $this->rangeByTypeGeneratorService = new RangeByTypeGenerator();
        $this->startDate = new \DateTime('2016-05-18');
    }

    public function test_givenTypeYesterday_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_YESTERDAY,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-05-17 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-17 23:59:59'), $range->getTo());
    }

    public function test_givenTypeThisWeek_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_THIS_WEEK,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-05-16 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-22 23:59:59'), $range->getTo());
    }

    public function test_givenTypeThisWeekStartMonday_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_THIS_WEEK,
            new \DateTime('2016-05-16 00:01:01')
        );

        $this->assertEquals(new \DateTime('2016-05-16 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-22 23:59:59'), $range->getTo());
    }

    public function test_givenTypeThisWeekStartSunday_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_THIS_WEEK,
            new \DateTime('2016-05-22 00:01:01')
        );

        $this->assertEquals(new \DateTime('2016-05-16 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-22 23:59:59'), $range->getTo());
    }

    public function test_givenTypeLastWeek_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_LAST_WEEK,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-05-09 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-15 23:59:59'), $range->getTo());
    }

    public function test_givenTypeLastWeekStartMonday_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_LAST_WEEK,
            new \DateTime('2016-05-16 00:01:01')
        );

        $this->assertEquals(new \DateTime('2016-05-09 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-15 23:59:59'), $range->getTo());
    }

    public function test_givenTypeLastWeekStartSunday_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_LAST_WEEK,
            new \DateTime('2016-05-22 00:01:01')
        );

        $this->assertEquals(new \DateTime('2016-05-09 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-15 23:59:59'), $range->getTo());
    }

    public function test_givenTypeLastThirtyDays_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_LAST_THIRTY_DAYS,
            new \DateTime('2016-05-22 00:01:01')
        );

        $this->assertEquals(new \DateTime('2016-04-22 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-22 23:59:59'), $range->getTo());
    }

    public function test_givenTypeThisMonth_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_THIS_MONTH,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-05-01 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-05-31 23:59:59'), $range->getTo());
    }

    public function test_givenTypeLastMonth_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_LAST_MONTH,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-04-01 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-04-30 23:59:59'), $range->getTo());
    }

    public function test_givenTypeThisQuarter_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_THIS_QUARTER,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-04-01 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-06-30 23:59:59'), $range->getTo());
    }

    public function test_givenThisYear_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_THIS_YEAR,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2016-01-01 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2016-12-31 23:59:59'), $range->getTo());
    }

    public function test_givenLastYear_returnCorrectRange()
    {
        $range = $this->rangeByTypeGeneratorService->handle(
            RangeByTypeGenerator::TYPE_LAST_YEAR,
            $this->startDate
        );

        $this->assertEquals(new \DateTime('2015-01-01 00:00:00'), $range->getFrom());
        $this->assertEquals(new \DateTime('2015-12-31 23:59:59'), $range->getTo());
    }
}