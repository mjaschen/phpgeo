# Line

A polyline consists of two points, i. e. instances of the `Coordinate` class.

## Length

```php
<?php

use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Line;

$line = new Line(
    new Coordinate(52.5, 13.5),
    new Coordinate(52.6, 13.4)
);

printf("The line has a length of %.3f meters\n", $line->getLength(new Haversine()));
```

The code above will produce the output below:

```
The line has a length of 13013.849 meters
```
