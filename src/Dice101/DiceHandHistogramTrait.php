<?php
/**
 * This file contains code to implement the trait HistogramTrait2.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice101;

/**
 * A trait implementing histogram for integers.
 */
trait DiceHandHistogramTrait
{
    /**
     * @var array $series  The numbers stored in sequence.
     */
    private $series = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSeries()
    {
        return $this->series;
    }



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return 1;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return $this->getDice()[0]->getSides();
    }
}
