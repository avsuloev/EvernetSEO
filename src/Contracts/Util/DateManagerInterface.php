<?php

namespace App\Contracts\Util;

interface DateManagerInterface
{
    public const BEFORE_DATE = 'before';
    public const AFTER_DATE = 'after';

    public function getIntervalEdgeDates(
        int $daysInterval,
        ?string $format = null,
        ?\DateTime $edgeDate = null,
        ?string $direction = null,
    ): array;
}
