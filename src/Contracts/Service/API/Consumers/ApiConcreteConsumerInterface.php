<?php

namespace App\Contracts\Service\API\Consumers;

use App\Contracts\Service\API\ApiPersistedQueryInterface;

interface ApiConcreteConsumerInterface
{
    public function generatePersistedQuery(): ApiPersistedQueryInterface;
}
