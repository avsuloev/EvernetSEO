<?php

namespace App\Contracts\Service\API;

interface YMPeriodStrategyInterface extends YMApiStrategyInterface
{
    public function getStartDate(): string;
    public function getEndDate(): string;
}
