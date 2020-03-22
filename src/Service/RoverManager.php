<?php

namespace App\Service;

use App\Entity\Rover;

class RoverManager
{
    private const TURN_LEFT = 'L';
    private const TURN_RIGHT = 'R';

    private const MOVE_FORWARD = 'M';

    private PlateauManager $plateauManager;

    public function __construct(PlateauManager $plateauManager)
    {
        $this->plateauManager = $plateauManager;
    }

    /**
     * @param Rover $rover
     * @param string $command
     */
    public function moveByCommand(Rover $rover, string $command): void
    {
        switch ($command) {
            case self::TURN_LEFT:
                $this->turnLeft($rover);
                break;
            case self::TURN_RIGHT:
                $this->turnRight($rover);
                break;
            case self::MOVE_FORWARD:
                $this->moveForward($rover);
                break;
        }
    }

    /**
     * @param Rover $rover
     */
    private function turnLeft(Rover $rover): void
    {
        $directions = Rover::getDirections();
        $currentDirection = array_search($rover->getDirection(), $directions);

        $newDirection = $currentDirection - 1;
        $newDirection = $newDirection >= 0 ? $newDirection : array_key_last($directions);

        $rover->setDirection($directions[$newDirection]);
    }

    /**
     * @param Rover $rover
     */
    private function turnRight(Rover $rover): void
    {
        $directions = Rover::getDirections();
        $currentDirection = array_search($rover->getDirection(), $directions);

        $newDirection = $currentDirection + 1;
        $newDirection = $newDirection < count($directions) ? $newDirection : 0;

        $rover->setDirection($directions[$newDirection]);
    }

    private function moveForward(Rover $rover): void
    {
        [$xCoordinate, $yCoordinate] = $this->getNewCoordinates($rover);

        $isOnThePlateau = $this->plateauManager->isOnThePlateau($rover->getPlateau(), $xCoordinate, $yCoordinate);

        if ($isOnThePlateau) {
            $rover->setXCoordinate($xCoordinate);
            $rover->setYCoordinate($yCoordinate);
        }
    }

    /**
     * @param Rover $rover
     * @return array
     * @throws \Exception
     */
    private function getNewCoordinates(Rover $rover): array
    {
        switch ($rover->getDirection()) {
            case Rover::DIRECTION_NORTH:
                return [$rover->getXCoordinate(), $rover->getYCoordinate() + 1];
            case Rover::DIRECTION_SOUTH:
                return [$rover->getXCoordinate(), $rover->getYCoordinate() - 1];
            case Rover::DIRECTION_WEST:
                return [$rover->getXCoordinate() - 1, $rover->getYCoordinate()];
            case Rover::DIRECTION_EAST:
                return [$rover->getXCoordinate() + 1, $rover->getYCoordinate()];
        }

        throw new \Exception(sprintf('There is no such direction as: %s', $rover->getDirection()));
    }
}