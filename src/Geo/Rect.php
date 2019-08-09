<?php declare(strict_types=1);

namespace App\Geo;

final class Rect
{
    /**
     * @var Point
     */
    private $upperLeft;

    /**
     * @var Point
     */
    private $lowerRight;

    /**
     * Rect constructor.
     * @param Point $upperLeft
     * @param Point $lowerRight
     */
    public function __construct(Point $upperLeft, Point $lowerRight)
    {
        $this->upperLeft = $upperLeft;
        $this->lowerRight = $lowerRight;
    }

    /**
     * @return Point
     */
    public function getUpperLeft(): Point
    {
        return $this->upperLeft;
    }

    /**
     * @return Point
     */
    public function getLowerRight(): Point
    {
        return $this->lowerRight;
    }
}