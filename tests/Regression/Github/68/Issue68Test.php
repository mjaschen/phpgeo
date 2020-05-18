<?php

declare(strict_types=1);

namespace Location;

use Location\Factory\CoordinateFactory;
use PHPUnit\Framework\TestCase;

class Issue68Test extends TestCase
{
    public function testIfIssue68IsFixed(): void
    {
        $coordinates = CoordinateFactory::fromString('11°17′N 15°50′W');

        $expectedLatitude = 11.283333333;
        $expectedLongitude = -15.833333333;

        $this->assertEqualsWithDelta($expectedLatitude, $coordinates->getLat(), 0.00001);
        $this->assertEqualsWithDelta($expectedLongitude, $coordinates->getLng(), 0.00001);
    }
}
