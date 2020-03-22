<?php

namespace App\Service;

use App\Entity\Plateau;

/**
 * Class PlateauManager
 * @package App\Service
 */
class PlateauManager
{
    /**
     * @param Plateau $plateau
     * @param int $xCoordinate
     * @param int $yCoordinate
     * @return bool
     */
    public function isOnThePlateau(Plateau $plateau, int $xCoordinate, int $yCoordinate): bool
    {
        return $xCoordinate >= 0
            && $xCoordinate <= $plateau->getWidth()
            && $yCoordinate >= 0
            && $yCoordinate <= $plateau->getHeight()
        ;
    }
}