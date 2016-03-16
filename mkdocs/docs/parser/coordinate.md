# Coordinates Parser

phpgeo comes with a parser for several types of coordinate formats.
The parser works as a factory which creates an instance of the
`Coordinate` class.

## Supported Formats

**Decimal Degrees** with or without *cardinal letters*,
with or without a comma as separator, with or without
whitespace between values and cardinal letters:

    52.5, 13.5
    52.5 13.5
    -52.5 -13.5
    52.345 N, 13.456 E
    N52.345 E13.456

**Decimal Minutes** with or without cardinal letters, with
or without degree and minute signs, with or without a comma
as separator, with or without whitespace between values
and cardinal letters:

    N52° 12.345, E13° 34.567
    52° 12.345′ N, E13° 34.567′ E
    52 12.345, 013 34.567
    -52 12.345, -013 34.567

The [unit test](https://github.com/mjaschen/phpgeo/blob/master/tests/Location/Factory/CoordinateFactoryTest.php) shows some more examples.

## Example

```php
use Location\Factory\CoordinateFactory;
use Location\Formatter\Coordinate\DecimalDegrees;

require_once __DIR__ . '/vendor/autoload.php';

$point = CoordinateFactory::fromString('52° 13.698′ 020° 58.536′');

echo $point->format(new DecimalDegrees());
```

The code above produces the output below:

    52.22830 20.97560