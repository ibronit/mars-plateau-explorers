<?php

namespace App\Entity;

/**
 * Class Rover
 * @package App\Entity
 */
class Rover
{
    const DIRECTION_WEST = 'W';
    const DIRECTION_NORTH = 'N';
    const DIRECTION_EAST = 'E';
    const DIRECTION_SOUTH = 'S';

    private int $xCoordinate;

    private int $yCoordinate;

    private string $direction;

    private Plateau $plateau;

    /**
     * Rover constructor.
     * @param int $xCoordinate
     * @param int $yCoordinate
     * @param string $direction
     */
    public function __construct(int $xCoordinate, int $yCoordinate, string $direction)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
        $this->direction = $direction;
    }

    /**
     * @return int|string
     */
    public function getXCoordinate()
    {
        return $this->xCoordinate;
    }

    /**
     * @param int|string $xCoordinate
     */
    public function setXCoordinate($xCoordinate): void
    {
        $this->xCoordinate = $xCoordinate;
    }

    /**
     * @return int
     */
    public function getYCoordinate(): int
    {
        return $this->yCoordinate;
    }

    /**
     * @param int $yCoordinate
     */
    public function setYCoordinate(int $yCoordinate): void
    {
        $this->yCoordinate = $yCoordinate;
    }

    /**
     * @return int|string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param int|string $direction
     */
    public function setDirection($direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return Plateau
     */
    public function getPlateau(): Plateau
    {
        return $this->plateau;
    }

    /**
     * @param Plateau $plateau
     * @return $this
     */
    public function setPlateau(Plateau $plateau): void
    {
        $this->plateau = $plateau;
    }

    /**
     * @return array
     */
    public static function getDirections(): array
    {
        return [self::DIRECTION_WEST, self::DIRECTION_NORTH, self::DIRECTION_EAST, self::DIRECTION_SOUTH];
    }
}