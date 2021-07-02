<?php

namespace App\Exception\Service\API;

use App\Contracts\Service\API\Exception\YaMExceptionInterface;

class YandexMetrikaException extends \RuntimeException implements YaMExceptionInterface
{
}
