<?php

namespace App\Tests\Service\API;

use App\Service\API\Etxt;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EtxtTest extends KernelTestCase
{
    private ?Etxt $etxt;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->etxt = $container->get(Etxt::class);
    }
}
