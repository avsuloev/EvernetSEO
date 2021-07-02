<?php

namespace App\Tests\Service\API;

use App\Service\API\TopVisor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TopVisorTest extends KernelTestCase
{
    private ?TopVisor $visor;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->visor = $container->get(TopVisor::class);
    }
}
