<?php

namespace App\Contracts\Service\API;

interface YMParametersStrategyInterface extends YMApiStrategyInterface
{
    public function getLimit(): ?int;
    /**
     * Cache key MUST follow PHP-FIG 'PSR-6: Caching Interface' standard.
     *
     * @see https://www.php-fig.org/psr/psr-6/ [PSR-6.Definitions.Key] — allowed characters.
     */
    public function getCacheKey(): string;
}
