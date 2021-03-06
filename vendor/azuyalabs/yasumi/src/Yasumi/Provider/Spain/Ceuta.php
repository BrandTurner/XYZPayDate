<?php
/**
 * This file is part of the Yasumi package.
 *
 * Copyright (c) 2015 - 2017 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <stelgenhof@gmail.com>
 */

namespace Yasumi\Provider\Spain;

use DateTime;
use DateTimeZone;
use Yasumi\Holiday;
use Yasumi\Provider\ChristianHolidays;
use Yasumi\Provider\Spain;

/**
 * Provider for all holidays in Ceuta (Spain).
 *
 * Ceuta is an 18.5-square-kilometre (7.1 sq mi) autonomous city of Spain and an exclave located on the north coast of
 * Africa, sharing a western border with Morocco. Separated from the Iberian peninsula by the Strait of Gibraltar, Ceuta
 * lies along the boundary between the Mediterranean Sea and the Atlantic Ocean.
 *
 * @link http://en.wikipedia.org/wiki/Ceuta
 */
class Ceuta extends Spain
{
    use ChristianHolidays;

    /**
     * Code to identify this Holiday Provider. Typically this is the ISO3166 code corresponding to the respective
     * country or sub-region.
     */
    const ID = 'ES-CE';

    /**
     * Initialize holidays for Ceuta (Spain).
     */
    public function initialize()
    {
        parent::initialize();

        // Add custom Christian holidays
        $this->addHoliday($this->maundyThursday($this->year, $this->timezone, $this->locale, Holiday::TYPE_OBSERVANCE));

        // Calculate other holidays
        $this->calculateDayOfCeuta();
    }

    /**
     * Calculates the Day of Ceuta.
     *
     * The Day of Ceuta (Día de Ceuta) is an annual public holiday in the city of Ceuta, Spain, on September 2.
     * This local holiday marks the date when Pedro de Menezes (or Meneses), Count of Viana do Alentejo, took control of
     * the city from King John I of Portugal on September 2, 1415.
     *
     * @link http://www.timeanddate.com/holidays/spain/the-independent-city-ceuta-day
     */
    public function calculateDayOfCeuta()
    {
        if ($this->year >= 1416) {
            $this->addHoliday(new Holiday('ceutaDay', ['es_ES' => 'Día de Ceuta'],
                new DateTime("$this->year-9-2", new DateTimeZone($this->timezone)), $this->locale));
        }
    }
}
