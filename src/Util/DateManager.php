<?php

namespace App\Util;

use App\Contracts\Util\DateManagerInterface;
use Carbon\Carbon;

class DateManager implements DateManagerInterface
{
    public function getIntervalEdgeDates(
        int $daysInterval,
        ?string $format = null,
        ?\DateTime $edgeDate = null,
        ?string $direction = null,
    ): array {
        $format = $format ?? 'Y-m-d';
        $direction = $direction ?? self::BEFORE_DATE;
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
