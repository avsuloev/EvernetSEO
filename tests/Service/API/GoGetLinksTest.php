<?php

namespace App\Tests\Service\API;

use App\Service\API\GoGetLinks;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GoGetLinksTest extends KernelTestCase
{
    private ?GoGetLinks $ggLinks;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->ggLinks = $container->get(GoGetLinks::class);
    }
}
