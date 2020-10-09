<?php

declare(strict_types=1);

namespace Location\CardinalDirection;

use Location\Exception\InvalidDistanceException;

/** @psalm-immutable */
class CardinalDirectionDistances
{
    /**
     * @var float
     */
    private $north;

    /**
     * @var float
     */
    private $east;

    /**
     * @var float
     */
    private $south;

    /**
     * @var float
     */
    private $west;

    private function __construct(float $north, float $east, float $south, float $west)
    {
        $this->north = $north;
        $this->east = $east;
        $this->south = $south;
        $this->west = $west;
    }

    /**
     * @psalm-pure
     * @psalm-mutation-free
     */
    public static function create(): self
    {
        return new self(0, 0, 0, 0);
    }

    /**
     * @psalm-mutation-free
     */
    public function setNorth(float $north): self
    {
        $this->assertPositiveFloat($north);

        return new self($north, $this->east, $this->south, $this->west);
    }

    /**
     * @psalm-mutation-free
     */
    public function setEast(float $east): self
    {
        $this->assertPositiveFloat($east);

        return new self($this->north, $east, $this->south, $this->west);
    }

    /**
     * @psalm-mutation-free
     */
    public function setSouth(float $south): self
    {
        $this->assertPositiveFloat($south);

        return new self($this->north, $this->east, $south, $this->west);
    }

    /**
     * @psalm-mutation-free
     */
    public function setWest(float $west): self
    {
        $this->assertPositiveFloat($west);

        return new self($this->north, $this->east, $this->south, $west);
    }

    /**
     * @psalm-mutation-free
     */
    public function getNorth(): float
    {
        return $this->north;
    }

    /**
     * @psalm-mutation-free
     */
    public function getEast(): float
    {
        return $this->east;
    }

    /**
     * @psalm-mutation-free
     */
    public function getSouth(): float
    {
        return $this->south;
    }

    /**
     * @psalm-mutation-free
     */
    public function getWest(): float
    {
        return $this->west;
    }

    /**
     * @psalm-pure
     * @psalm-mutation-free
     *
     * @throws InvalidDistanceException
     */
    private function assertPositiveFloat(float $value): void
    {
        if ($value < 0) {
            throw new InvalidDistanceException('Negative distance is invalid.', 1857757416);
        }
    }
}
