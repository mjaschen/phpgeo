<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Exception\InvalidDistanceException;

class CardinalDirectionDistances
{
    private function __construct(
        private readonly float $north,
        private readonly float $east,
        private readonly float $south,
        private readonly float $west
    ) {
    }

    public static function create(): self
    {
        return new self(0, 0, 0, 0);
    }

    public function setNorth(float $north): self
    {
        $this->assertPositiveFloat($north);

        return new self($north, $this->east, $this->south, $this->west);
    }

    /**
     * @throws InvalidDistanceException
     */
    private function assertPositiveFloat(float $value): void
    {
        if ($value < 0) {
            throw new InvalidDistanceException('Negative distance is invalid.', 1_857_757_416);
        }
    }

    public function setEast(float $east): self
    {
        $this->assertPositiveFloat($east);

        return new self($this->north, $east, $this->south, $this->west);
    }

    public function setSouth(float $south): self
    {
        $this->assertPositiveFloat($south);

        return new self($this->north, $this->east, $south, $this->west);
    }

    public function setWest(float $west): self
    {
        $this->assertPositiveFloat($west);

        return new self($this->north, $this->east, $this->south, $west);
    }

    public function getNorth(): float
    {
        return $this->north;
    }

    public function getEast(): float
    {
        return $this->east;
    }

    public function getSouth(): float
    {
        return $this->south;
    }

    public function getWest(): float
    {
        return $this->west;
    }
}
