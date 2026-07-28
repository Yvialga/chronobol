<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**Ensure that php bin/phpunit works in first time.
 * Useful when exceptions are caught. */
class UnitTestWorksWell extends KernelTestCase
{
    public function testUnitTestWorks() {
        $this->assertTrue(true);
    }
}