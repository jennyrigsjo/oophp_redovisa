<?php
/**
 * This file contains code to implement the class HistogramInterface.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice101;

/**
 * An interface for a classes supporting histogram reports.
 */
interface DiceHandHistogramInterface
{
    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSeries();



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin();



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax();
}
