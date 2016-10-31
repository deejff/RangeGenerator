<?php

namespace Deejff\RangeGenerator;

class RangeByTypeGenerator
{
    const TYPE_TODAY = 'today';
    const TYPE_YESTERDAY = 'yesterday';
    const TYPE_THIS_WEEK = 'this_week';
    const TYPE_LAST_WEEK = 'last_week';
    const TYPE_LAST_THIRTY_DAYS = 'last_thirty_days';
    const TYPE_THIS_MONTH = 'this_month';
    const TYPE_LAST_MONTH = 'last_month';
    const TYPE_THIS_QUARTER = 'this_quarter';
    const TYPE_THIS_YEAR = 'this_year';
    const TYPE_LAST_YEAR = 'last_year';

    private $methodsForTypesMap = [
        self::TYPE_TODAY => 'rangeToday',
        self::TYPE_YESTERDAY => 'rangeYesterday',
        self::TYPE_THIS_WEEK => 'rangeThisWeek',
        self::TYPE_LAST_THIRTY_DAYS => 'rangeLastThirtyDays',
        self::TYPE_LAST_WEEK => 'rangeLastWeek',
        self::TYPE_THIS_MONTH => 'rangeThisMonth',
        self::TYPE_LAST_MONTH => 'rangeLastMonth',
        self::TYPE_THIS_YEAR => 'rangeThisYear',
        self::TYPE_THIS_QUARTER => 'rangeThisQuarter',
        self::TYPE_LAST_YEAR => 'rangeLastYear'
    ];

    private $daysMap = [
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday'
    ];

    private $weekStartDay = 1;

    public function __construct($weekStartDay = 1)
    {
        if (!array_key_exists($weekStartDay, $this->daysMap)) {
            throw new \RuntimeException('Incorrect day.');
        }

        $this->weekStartDay = $weekStartDay;
    }

    /**
     * @param $type
     * @param $startDate
     *
     * @return DateRange
     */
    public function handle($type, \DateTime $startDate = null)
    {
        if (!isset($this->methodsForTypesMap[$type])) {
            throw new \RuntimeException('Not found type:'. $type);
        }

        if (empty($startDate)) {
            $startDate = new \DateTime();
        }

        $functionName = $this->methodsForTypesMap[$type];

        return $this->$functionName($startDate);
    }

    public function getRangeTypes()
    {
        return [
            self::TYPE_TODAY,
            self::TYPE_YESTERDAY,
            self::TYPE_THIS_WEEK,
            self::TYPE_LAST_WEEK,
            self::TYPE_LAST_THIRTY_DAYS.
            self::TYPE_THIS_MONTH,
            self::TYPE_LAST_MONTH,
            self::TYPE_THIS_QUARTER,
            self::TYPE_THIS_YEAR,
            self::TYPE_LAST_YEAR,
        ];
    }

    protected function rangeToday(\DateTime $startDate)
    {
        $from = clone $startDate;
        $to = clone $startDate;
        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeYesterday(\DateTime $startDate)
    {
        $yesterday = $startDate->modify('yesterday');

        $from = clone $yesterday;
        $from->setTime(0, 0, 0);

        $to = clone $yesterday;
        $to = $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeThisWeek(\DateTime $startDate)
    {
        $from = clone $startDate;
        $dayOfWeek = $startDate->format('w');

        if ($this->weekStartDay == $dayOfWeek) {
            $from->setTime(0, 0, 0);
            $to = clone $from;
            $to->modify('+6 days')->setTime(23,59,59);
        } else {
            $startDayAsString =  $this->daysMap[$this->weekStartDay];
            $from->modify('last '.$startDayAsString);
            $from->setTime(0, 0, 0);
            $to = clone $from;
            $to->modify('+6 days')->setTime(23,59,59);
        }

        return new DateRange($from, $to);
    }

    protected function rangeLastWeek(\DateTime $startDate)
    {
        $startDataWeekAgo = clone $startDate;
        $startDataWeekAgo->modify('-1 week');

        return $this->rangeThisWeek($startDataWeekAgo);
    }

    protected function rangeLastThirtyDays(\DateTime $startDate)
    {
        $from = clone $startDate;
        $from = $from->modify('- 30 days');
        $to = clone $startDate;

        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeThisMonth(\DateTime $startDate)
    {
        $from = clone $startDate;
        $from = $from->modify('first day of this month');
        $to = clone $startDate;
        $to = $to->modify('last day of this month');

        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeLastMonth(\DateTime $startDate)
    {
        $from = clone $startDate;
        $from = $from->modify('first day of last month');
        $to = clone $startDate;
        $to = $to->modify('last day of last month');

        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeThisQuarter(\DateTime $startDate)
    {
        $startDate = clone $startDate;
        $startDate->modify('- 1 day');

        $month = $startDate->format('n') ;

        $from = null;
        $to = null;

        if ($month < 4) {
            $from = (new \DateTime())->modify('first day of january' . $startDate->format('Y'));
            $to = (new \DateTime())->modify('last day of march ' . $startDate->format('Y'));
        } elseif ($month > 3 && $month < 7) {
            $from = (new \DateTime())->modify('first day of april' . $startDate->format('Y'));
            $to = (new \DateTime())->modify('last day of june ' . $startDate->format('Y'));
        } elseif ($month > 6 && $month < 10) {
            $from = (new \DateTime())->modify('first day of july' . $startDate->format('Y'));
            $to = (new \DateTime())->modify('last day of september' . $startDate->format('Y'));
        } elseif ($month > 9) {
            $from = (new \DateTime())->modify('first day of october' . $startDate->format('Y'));
            $to = (new \DateTime())->modify('last day of december' . $startDate->format('Y'));
        }

        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeThisYear(\DateTime $startDate)
    {
        $startDate = clone $startDate;

        $from = (new \DateTime())->modify('first day of january' . $startDate->format('Y'));
        $to = (new \DateTime())->modify('last day of december' . $startDate->format('Y'));

        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }

    protected function rangeLastYear(\DateTime $startDate)
    {
        $dateClone = clone $startDate;
        $lastYearDate = $dateClone->modify('- 1 year');

        $from = (new \DateTime())->modify('first day of january' . $lastYearDate->format('Y'));
        $to = (new \DateTime())->modify('last day of december' . $lastYearDate->format('Y'));

        $from->setTime(0, 0, 0);
        $to->setTime(23, 59, 59);

        return new DateRange($from, $to);
    }
}