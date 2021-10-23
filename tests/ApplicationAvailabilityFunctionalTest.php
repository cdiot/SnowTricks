<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessfulFrAnonymousUser($url, $expectedStatus = 200)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame($expectedStatus);
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/show/figure-1'];
        yield ['/login'];
        yield ['/register'];
        yield ['/reset-password'];
        yield ['/figure/new', 302];
        yield ['/figure/figure-2/edit', 302];
        yield ['/figure/figure-3/delete', 302];
    }
}
