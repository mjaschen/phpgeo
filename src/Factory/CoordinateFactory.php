<?php

declare(strict_types=1);

namespace Location\Factory;

use InvalidArgumentException;
use Location\Coordinate;
use Location\Ellipsoid;

class CoordinateFactory implements GeometryFactoryInterface
{
    /**
     * Creates a Coordinate instance from the given string.
     *
     * The string is parsed by a regular expression for a known
     * format of geographical coordinates.
     *
     * @param  string  $string  formatted geographical coordinate
     *
     * @throws InvalidArgumentException
     */
    public static function fromString(string $string, ?Ellipsoid $ellipsoid = null): Coordinate
    {
        $string = self::mergeSecondsToMinutes($string);

        $result = self::parseDecimalMinutesWithoutCardinalLetters($string, $ellipsoid);

        if ($result instanceof Coordinate) {
            return $result;
        }

        $result = self::parseDecimalMinutesWithCardinalLetters($string, $ellipsoid);

        if ($result instanceof Coordinate) {
            return $result;
        }

        $result = self::parseDecimalDegreesWithoutCardinalLetters($string, $ellipsoid);

        if ($result instanceof Coordinate) {
            return $result;
        }

        $result = self::parseDecimalDegreesWithCardinalLetters($string, $ellipsoid);

        if ($result instanceof Coordinate) {
            return $result;
        }

        throw new InvalidArgumentException('Format of coordinates was not recognized', 2353695193);
    }

    private static function mergeSecondsToMinutes(string $string): string
    {
        return preg_replace_callback(
            '/(\d+)(°|\s)\s*(\d+)(\'|′|\s)(\s*([0-9\.]*))("|\'\'|″|′′)?/u',
            static fn(array $matches): string => sprintf(
                '%d %f',
                $matches[1],
                (float)$matches[3] + (float)$matches[6] / 60
            ),
            $string
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function parseDecimalMinutesWithoutCardinalLetters(
        string $string,
        Ellipsoid|null $ellipsoid = null
    ): Coordinate|null {
        // Decimal minutes without cardinal letters, e. g. "52 12.345, 13 23.456",
        // "52° 12.345, 13° 23.456", "52° 12.345′, 13° 23.456′", "52 12.345 N, 13 23.456 E",
        // "N52° 12.345′ E13° 23.456′"
        $regexp = '/(-?\d{1,2})°?\s+(\d{1,2}\.?\d*)[\'′]?[, ]\s*(-?\d{1,3})°?\s+(\d{1,2}\.?\d*)[\'′]?/u';

        if (preg_match($regexp, $string, $match) === 1) {
            $latitude = (int)$match[1] >= 0
                ? (int)$match[1] + (float)$match[2] / 60
                : (int)$match[1] - (float)$match[2] / 60;
            $longitude = (int)$match[3] >= 0
                ? (int)$match[3] + (float)$match[4] / 60
                : (int)$match[3] - (float)$match[4] / 60;

            return new Coordinate($latitude, $longitude, $ellipsoid);
        }

        return null;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function parseDecimalMinutesWithCardinalLetters(
        string $string,
        Ellipsoid|null $ellipsoid = null
    ): Coordinate|null {
        // Decimal minutes with cardinal letters, e. g. "52 12.345, 13 23.456",
        // "52° 12.345, 13° 23.456", "52° 12.345′, 13° 23.456′", "52 12.345 N, 13 23.456 E",
        // "N52° 12.345′ E13° 23.456′"
        $regexp = '/([NS]?\s*)(\d{1,2})°?\s+(\d{1,2}\.?\d*)[\'′]?(\s*[NS]?)';
        $regexp .= '[, ]\s*([EW]?\s*)(\d{1,3})°?\s+(\d{1,2}\.?\d*)[\'′]?(\s*[EW]?)/ui';

        if (preg_match($regexp, $string, $match) === 1) {
            $latitude = (int)$match[2] + (float)$match[3] / 60;
            if (strtoupper(trim($match[1])) === 'S' || strtoupper(trim($match[4])) === 'S') {
                $latitude = -$latitude;
            }
            $longitude = (int)$match[6] + (float)$match[7] / 60;
            if (strtoupper(trim($match[5])) === 'W' || strtoupper(trim($match[8])) === 'W') {
                $longitude = -$longitude;
            }

            return new Coordinate($latitude, $longitude, $ellipsoid);
        }

        return null;
    }

    /**
     * @return Coordinate|null
     * @throws InvalidArgumentException
     */
    private static function parseDecimalDegreesWithoutCardinalLetters(string $string, ?Ellipsoid $ellipsoid = null)
    {
        // The most simple format: decimal degrees without cardinal letters,
        // e. g. "52.5, 13.5" or "53.25732 14.24984"
        if (preg_match('/(-?\d{1,2}\.?\d*)°?[, ]\s*(-?\d{1,3}\.?\d*)°?/u', $string, $match) === 1) {
            return new Coordinate((float)$match[1], (float)$match[2], $ellipsoid);
        }

        return null;
    }

    /**
     * @return Coordinate|null
     * @throws InvalidArgumentException
     */
    private static function parseDecimalDegreesWithCardinalLetters(string $string, ?Ellipsoid $ellipsoid = null)
    {
        // Decimal degrees with cardinal letters, e. g. "N52.5, E13.5",
        // "40.2S, 135.3485W", or "56.234°N, 157.245°W"
        $regexp = '/([NS]?\s*)(\d{1,2}\.?\d*)°?(\s*[NS]?)[, ]\s*([EW]?\s*)(\d{1,3}\.?\d*)°?(\s*[EW]?)/ui';

        if (preg_match($regexp, $string, $match) === 1) {
            $latitude = (float)$match[2];
            if (strtoupper(trim($match[1])) === 'S' || strtoupper(trim($match[3])) === 'S') {
                $latitude = -$latitude;
            }
            $longitude = (float)$match[5];
            if (strtoupper(trim($match[4])) === 'W' || strtoupper(trim($match[6])) === 'W') {
                $longitude = -$longitude;
            }

            return new Coordinate($latitude, $longitude, $ellipsoid);
        }

        return null;
    }
}
