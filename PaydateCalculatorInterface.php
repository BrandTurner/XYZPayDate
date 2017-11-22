<?php

/*  Stretch Goals
*   --------------
*   - Print paydates out for entire year
*   - Given a wage or salary, calculate earnings per paydate
*   - Create front-end interface (React) that lets you input paydate vars (Put on BrandTurner.com behind password protected page)
*   - Use holidays npm package or holidaysapi.com to get holidays for all years
*   - PHPDOC
*/

interface PaydateCalculatorInterface
{

    /**
     * This function takes a paydate model and a first paydate and generates the next $number_of_paydates paydates.
     *
     * @param string $paydateModel The paydate model, one of the items in the spec
     * @param string $paydateOne First paydate as a string in Y-m-d format, different from the second
     * @param int $numberOfPaydates The number of paydates to generate
     *
     * @return array the next paydates (from today) as strings in Y-m-d format
     */
    public function calculateNextPaydates($paydateModel, $paydateOne, $numberOfPaydates);

    /**
     * This function determines whether a given date in Y-m-d format is a holiday.
     *
     * @param string $date A date as a string formatted as Y-m-d
     *
     * @return boolean whether or not the given date is on a holiday
     */
    public function isHoliday($date);

    /**
     * This function determines whether a given date in Y-m-d format is on a weekend.
     *
     * @param string $date A date as a string formatted as Y-m-d
     *
     * @return boolean whether or not the given date is on a weekend
     */
    public function isWeekend($date);

    /**
     * This function determines whether a given date in Y-m-d format is a valid paydate according to specification rules.
     *
     * @param string $date A date as a string formatted as Y-m-d
     *
     * @return boolean whether or not the given date is a valid paydate
     */
    public function isValidPaydate($date);

    /**
     * This function increases a given date in Y-m-d format by $count $units
     *
     * @param string $date A date as a string formatted as Y-m-d
     * @param integer $count The amount of units to increment
     * @param string $unit adjustment unit
     *
     * @return string the calculated day's date as a string in Y-m-d format
     */
    public function increaseDate($date, $count, $unit = 'days');

    /**
     * This function decreases a given date in Y-m-d format by $count $units
     *
     * @param string $date A date as a string formatted as Y-m-d
     * @param integer $count The amount of units to decrement
     * @param string $unit adjustment unit
     *
     * @return string the calculated day's date as a string in Y-m-d format
     */
    public function decreaseDate($date, $count, $unit = 'days');


}
