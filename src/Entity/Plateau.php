<?php

namespace App\Entity;

/**
 * Class Plateau
 * @package App\Entity
 */
class Plateau
{
    private int $height;

    private int $width;

    private array $rovers = [];

    /**
     * Plateau constructor.
     * @param int $height
     * @param int $width
     */
    public function __construct(int $height, int $width)
    {
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return array
     */
    public function getRovers(): array
    {
        return $this->rovers;
    }

    /**
     * @param Rover $rover
     * @return $this
     */
    public function addRover(Rover $rover): void
    {
        if(!in_array($rover, $this->rovers)) {
            $this->rovers[] = $rover;
            $rover->setPlateau($this);
        }
    }
}