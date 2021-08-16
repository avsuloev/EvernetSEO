<?php

namespace App\Service\API\YandexMetrika\PeriodStrategy;

use App\Contracts\Service\API\YMPeriodStrategyInterface;
use Carbon\Carbon;

/**
 * API data for last int $periodInDays days.
 */
class RecentPeriodStrategy implements YMPeriodStrategyInterface
{
    use YMPeriodStrategyTrait;

    public const BEFORE_DATE = 'before';
    public const AFTER_DATE = 'after';

    public function __construct(int $periodInDays)
    {
        [$this->startDate, $this->endDate] = $this->getIntervalEdgeDates($periodInDays);

        $this->parameters = [
            'date1' => $this->startDate,
            'date2' => $this->endDate,
        ];
    }

    private function getIntervalEdgeDates(
        int $daysInterval,
        ?string $format = null,
        ?\DateTime $edgeDate = null,
        ?string $direction = null,
    ): array {
        $format ??= 'Y-m-d';
        $direction ??= self::BEFORE_DATE;
        $initialEdge = null !== $edgeDate ? Carbon::instance($edgeDate) : Carbon::today();
        if (self::BEFORE_DATE === $direction) {
            $startDate = $initialEdge->subDays($daysInterval);
            $endDate = $initialEdge;
        }
        if (self::AFTER_DATE === $direction) {
            $startDate = $initialEdge;
            $endDate = $initialEdge->addDays($daysInterval);
        }

        return [$startDate->format($format), $endDate->format($format)];
    }
}
