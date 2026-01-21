## Directions

With the `Direction` class it's possible to determine if one point is north, east, south or west of another point.

```php
<?php

use Location\Coordinate;

$berlin = new Coordinate(52.5, 13.5);
$rome = new Coordinate(42, 12.5);
$helsinki = new Coordinate(60, 25);

$direction = new Direction();

if ($direction->pointIsNorthOf(point: $helsinki, compareAgainst: $berlin)) {
  echo 'Helsinki is located north of Berlin.' . PHP_EOL;
}  else {
  echo 'Berlin is located north of Helsinki.' . PHP_EOL;
}

if ($direction->pointIsEastOf(point: $rome, compareAgainst: $berlin)) {
  echo 'Rome is located east of Berlin.' . PHP_EOL;
}  else {
  echo 'Berlin is located east of Rome.' . PHP_EOL;
}
```

The code above will produce the output below:

``` plaintext
Helsinki is located north of Berlin.
Berlin is located east of Rome.
```
