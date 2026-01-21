## Same Point Comparison

It's possible to check if two points describe the same location – and optionally allow an error margin.

``` php
<?php

use Location\Coordinate;

$coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
$coordinate2 = new Coordinate(20.709722, -156.253333); // Haleakala Summit

echo $coordinate1->hasSameLocation($coordinate2)
    ? 'Mauna Kea and Haleakala share the same location.'
    : 'Mauna Kea and Haleakala have different locations.';

$coordinate1 = new Coordinate(19.820664, -155.468066); // Mauna Kea Summit
$coordinate2 = new Coordinate(19.82365, -155.46905); // Gemini North Telescope

echo $coordinate1->hasSameLocation($coordinate2, 1000)
    ? 'Mauna Kea and the Gemini North Telescope are located within the same 1 km-radius.'
    : 'Mauna Kea and the Gemini North Telescope are located more than 1 km apart.';
```

The code above will produce the output below:

``` plaintext
Mauna Kea and Haleakala have different locations.
Mauna Kea and the Gemini North Telescope are located within the same 1 km-radius.
```
