<?php

namespace App\Util;

use App\Contracts\Service\API\YMParametersStrategyInterface;

use App\Exception\Util\OptionsValidatorException;

class OptionsValidator
{
    private ?string $logName;

    public function __construct(?string $logName)
    {
        $this->logName = $logName ?? (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @todo: implement logic.
     */
    public function validateProxyAddress(string $proxyAddress): bool
    {
        $toDoCondition = is_string($proxyAddress);
        if ($toDoCondition) {
            return true;
        }

        // todo: prefer \InvalidArgumentException?
        throw new OptionsValidatorException(
            "$this->logName: proxy parameter is invalid [PROXY: '$this->$proxyAddress']."
        );
    }
}
