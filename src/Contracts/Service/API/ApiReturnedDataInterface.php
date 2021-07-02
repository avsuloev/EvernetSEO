<?php

namespace App\Contracts\Service\API;

interface ApiReturnedDataInterface
{
    public function getData(): ?array;
}
