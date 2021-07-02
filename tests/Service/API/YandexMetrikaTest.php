<?php

namespace App\Tests\Service\API;

use App\Service\API\YandexMetrika;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class YandexMetrikaTest extends KernelTestCase
{
    private ?YandexMetrika $metrika;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->metrika = $container->get(YandexMetrika::class);
    }

    public function testInit()
    {
        // ...
    }

    /**
     * @depends testInit
     */
    public function testRequest()
    {
        $this->yaMetrika->getRequestToApi();

        // ...
    }

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }
}
