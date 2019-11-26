# Formatting Coordinates

You can format a coordinate in different styles.

## Decimal Degrees

``` php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

$coordinate = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit

echo $coordinate->format(new DecimalDegrees());
```

The code above produces the output below:

``` plaintext
19.82066 -155.46807
```

The separator string between latitude and longitude can be configured via
constructor argument, as well as the number of decimals (default value is
5 digits):

``` php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

$coordinate = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit

echo $coordinate->format(new DecimalDegrees(', ', 3));
```

The code above produces the output below:

``` plaintext
19.821, -155.468
```

## Degrees/Minutes/Seconds (DMS)

``` php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DMS;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

$formatter = new DMS();

echo $coordinate->format($formatter) . PHP_EOL;

$formatter->setSeparator(', ')
    ->useCardinalLetters(true)
    ->setUnits(DMS::UNITS_ASCII);

echo $coordinate->format($formatter) . PHP_EOL;
```

The code above produces the output below:

``` plaintext
18° 54′ 41″ -155° 40′ 42″
18° 54' 41" N, 155° 40' 42" W
```

## Decimal Minutes

This format is commonly used in the Geocaching community.

``` php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalMinutes;

$coordinate = new Coordinate(43.62310, -70.20787); // Portland Head Light, ME, USA

$formatter = new DecimalMinutes();

echo $coordinate->format($formatter) . PHP_EOL;

$formatter->setSeparator(', ')
    ->useCardinalLetters(true)
    ->setUnits(DecimalMinutes::UNITS_ASCII);

echo $coordinate->format($formatter) . PHP_EOL;
```

The code above produces the output below:

``` plaintext
43° 37.386′ -070° 12.472′
43° 37.386' N, 070° 12.472' W
```

## GeoJSON

``` php
<?php

use Location\Coordinate;
use Location\Formatter\Coordinate\GeoJSON;

$coordinate = new Coordinate(18.911306, -155.678268); // South Point, HI, USA

echo $coordinate->format(new GeoJSON());
```

The code above produces the output below:

``` json
{"type":"Point","coordinates":[-155.678268,18.911306]}
```

NOTE: Float values processed by `json_encode()` are affected by the ini-setting
[`serialize_precision`](https://secure.php.net/manual/en/ini.core.php#ini.serialize-precision).
You can change the number of decimal places in the JSON output by changing
that ini-option, e. g. with `ini_set('serialize_precision', 8)`.
