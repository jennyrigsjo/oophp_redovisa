<?php
/**
 * This file contains code to implement the class Histogram.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice101;

/**
 * A class implementing a histogram.
 */
class DiceHandHistogram
{
    /**
     * @var array $series  The numbers stored in sequence.
     */
    private $series = [];

    /**
     * @var int   $min    The lowest possible number.
     */
    private $min = null;

    /**
     * @var int   $max    The highest possible number.
     */
    private $max = null;

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param DiceHandHistogramInterface $diceHand The object holding the series.
     *
     * @return void.
     */
    public function injectData(DicehandHistogramInterface $diceHand)
    {
        $this->series = $diceHand->getHistogramSeries();
        $this->min = $diceHand->getHistogramMin();
        $this->max = $diceHand->getHistogramMax();
    }

    // /**
    //  * Get the series.
    //  *
    //  * @return array with with one or more series (arrays) of values.
    //  */
    // public function getSeries()
    // {
    //     return $this->series;
    // }

    /**
     * Get a graphic representation of the number of instances of each value rolled by the dice hand.
     *
     * @return string as a histogram of the number of instances of each value.
     */
    public function getHistogramString()
    {
        $histogramString = "";

        if (!empty($this->series)) {
            $mergedSeries = array_merge(...$this->series);
            $countInstances = array_count_values($mergedSeries);
            ksort($countInstances);

            for ($number = $this->min; $number <= $this->max; $number++) {
                if (array_key_exists($number, $countInstances)) {
                    $instances = $countInstances[$number];
                    $histogramString .= $this->buildString($number, $instances);
                } else {
                    $histogramString .= "{$number}:<br>";
                }
            }
        }

        return $histogramString;
    }

    /**
     * Helper function to create a histographic representation of a given value
     * and its occurrences, using the $value and $instances arguments supplied by
     * the getHistogramString function.
     * @param int $value The value/number
     * @param int $instances The number of occurrences of the value/number
     * @return string
     */
    private function buildString($value, $instances)
    {
        $string = "{$value}: ";
        $i = 0;
        while ($i < $instances) {
            $string .= "*";
            $i++;
        }
        $string .= "<br>";
        return $string;
    }
}
