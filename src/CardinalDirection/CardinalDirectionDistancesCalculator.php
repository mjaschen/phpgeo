<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Bounds;
use Location\Coordinate;
use Location\Distance\DistanceInterface;

class CardinalDirectionDistancesCalculator
{
    public function getCardinalDirectionDistances(
        Coordinate $point1,
        Coordinate $point2,
        DistanceInterface $distanceCalculator
    ): CardinalDirectionDistances {
        $cardinalDirection = (new CardinalDirection())->getCardinalDirection($point1, $point2);
        $directDistance = $point1->getDistance($point2, $distanceCalculator);

        switch ($cardinalDirection) {
            case CardinalDirection::CARDINAL_DIRECTION_NONE:
                return CardinalDirectionDistances::create();

            case CardinalDirection::CARDINAL_DIRECTION_NORTH:
                return CardinalDirectionDistances::create()->setSouth($directDistance);

            case CardinalDirection::CARDINAL_DIRECTION_EAST:
                return CardinalDirectionDistances::create()->setWest($directDistance);

            case CardinalDirection::CARDINAL_DIRECTION_SOUTH:
                return CardinalDirectionDistances::create()->setNorth($directDistance);

            case CardinalDirection::CARDINAL_DIRECTION_WEST:
                return CardinalDirectionDistances::create()->setEast($directDistance);

            case CardinalDirection::CARDINAL_DIRECTION_NORTHWEST:
                $bounds = new Bounds($point1, $point2);
                $point3 = new Coordinate($bounds->getNorth(), $bounds->getEast());

                return CardinalDirectionDistances::create()
                    ->setEast($point1->getDistance($point3, $distanceCalculator))
                    ->setSouth($point3->getDistance($point2, $distanceCalculator));

            case CardinalDirection::CARDINAL_DIRECTION_SOUTHWEST:
                $bounds = new Bounds(
                    new Coordinate($point2->getLat(), $point1->getLng()),
                    new Coordinate($point1->getLat(), $point2->getLng())
                );
                $point3 = new Coordinate($bounds->getSouth(), $bounds->getEast());

                return CardinalDirectionDistances::create()
                    ->setNorth($point3->getDistance($point2, $distanceCalculator))
                    ->setEast($point1->getDistance($point3, $distanceCalculator));

            case CardinalDirection::CARDINAL_DIRECTION_NORTHEAST:
                $bounds = new Bounds(
                    new Coordinate($point1->getLat(), $point2->getLng()),
                    new Coordinate($point2->getLat(), $point1->getLng())
                );
                $point3 = new Coordinate($bounds->getNorth(), $bounds->getWest());

                return CardinalDirectionDistances::create()
                    ->setSouth($point3->getDistance($point2, $distanceCalculator))
                    ->setWest($point1->getDistance($point3, $distanceCalculator));

            case CardinalDirection::CARDINAL_DIRECTION_SOUTHEAST:
                $bounds = new Bounds($point2, $point1);
                $point3 = new Coordinate($bounds->getSouth(), $bounds->getWest());

                return CardinalDirectionDistances::create()
                    ->setNorth($point3->getDistance($point2, $distanceCalculator))
                    ->setWest($point1->getDistance($point3, $distanceCalculator));
        }

        return CardinalDirectionDistances::create();
    }
}
