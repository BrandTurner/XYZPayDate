<?php /* ~(˘▾˘~) Good Luck (~˘▾˘)~ */

require 'vendor/autoload.php';

use Carbon\Carbon;

class MyPaydateCalculator {

  private $payPeriod        = null;
  private $payPeriodCycle   = null;

  public function __construct() {
    // Set default timezone
    date_default_timezone_set("America/Los_Angeles");
  }

  private function validateDate($date, $format = 'Y-m-d') {
      $d = DateTime::createFromFormat($format, $date);
      return $d && $d->format($format) == $date;
  }

  private function paydateModelSetter($paydateModel) {
    switch ($paydateModel) {
      case 'MONTHLY':
        $this->payPeriod = 'months';
        $this->payPeriodCycle = 1;
        break;

      case 'BIWEEKLY':
        $this->payPeriod = 'weeks';
        $this->payPeriodCycle = 2;
        break;

      case 'WEEKLY':
        $this->payPeriod = 'weeks';
        $this->payPeriodCycle = 1;
        break;

      default:
        throw new Exception ("Pay period must be WEEKLY, BIWEEKLY, OR MONTHLY");
        break;
    }
  }

  public function calculateNextPaydates($paydateModel, $paydateOne, $numberOfPaydates) {
    if (!$this->validateDate($paydateOne) || !(is_int($numberOfPaydates) && ((int) $numberOfPaydates > 0))) {
        try {
            throw new Exception("Invalid date or count! Please enter a date in a Y-m-d format or use a a positive non zero int for count", 17);
        } catch(Exception $e) {
            echo "The exception code is: " . $e->getCode();
        }
      }

      /*if (!$this->isValidPaydate($paydateOne)) {
            throw new Exception("First pay date is either a holiday or weekend. Exiting;");
        }*/

      $this->paydateModelSetter($paydateModel);

      $paydatesArray = array_fill(0, $numberOfPaydates, $paydateOne);
      $lastPaydate = $paydateOne;
      foreach ($paydatesArray as &$paydate) {
        $paydate = $this->increaseDate($lastPaydate, $this->payPeriodCycle, $this->payPeriod);

        if (!$this->isValidPaydate($paydate)) {
          $paydate = $this->getValidPaydate($paydate);
        }

        $lastPaydate = $paydate;
      }

      return $paydatesArray;
  }


  public function isHoliday($date) {
    if (!$this->validateDate($date)) {
      try {
          throw new Exception("Invalid date! Please enter a date in a Y-m-d format", 11);
      } catch(Exception $e) {
          echo "The exception code is: " . $e->getCode();
      }
    }

    $holidays = Yasumi\Yasumi::create('USA', substr($date, 0, 4));
    return in_array($date, $holidays->getHolidayDates());
  }


    public function isWeekend($date) {
      if (!$this->validateDate($date)) {
      try {
          throw new Exception("Invalid date! Please enter a date in a Y-m-d format", 12);
      } catch(Exception $e) {
          echo "The exception code is: " . $e->getCode();
      }
    }
      return Carbon::createFromFormat('Y-m-d', $date)->isWeekend();
    }

    public function isValidPaydate($date) {
      if (!$this->validateDate($date)) {
        try {
            throw new Exception("Invalid date! Please enter a date in a Y-m-d format", 10);
        } catch(Exception $e) {
            echo "The exception code is: " . $e->getCode();
        }
      }

      if ($this->isWeekend($date) || $this->isHoliday($date)) {
        return false;
      }

      // If payday is today, reutn false
      $first = Carbon::createFromFormat('Y-m-d', $date);
      $second = Carbon::now('America/Los_Angeles');
      if ($first->isSameDay($second)) return false;

      return true;
    }

    public function increaseDate($date, $count, $unit = 'days') {
      if (!$this->validateDate($date) || !(is_int($count) && ((int) $count > 0))) {
        try {
            throw new Exception("Invalid date or count! Please enter a date in a Y-m-d format or use a a positive non zero int for count", 13);
        } catch(Exception $e) {
            echo "The exception code is: " . $e->getCode();
        }
      }
      $count = (int) $count;
      $carbonDate = Carbon::createFromFormat('Y-m-d', $date);

      switch($unit) {
        case 'years':
          if ($count == 1) return $carbonDate->addYear()->toDateString();
          return $carbonDate->addYears($count)->toDateString();
          break;
        case 'months':
         if ($count == 1) return $carbonDate->addMonth()->toDateString();
          return $carbonDate->addMonths($count)->toDateString();
          break;
        case 'weeks':
          if ($count == 1) return $carbonDate->addWeek()->toDateString();
          return $carbonDate->addWeeks($count)->toDateString();
          break;
        case 'days':
          if ($count == 1) return $carbonDate->addDay()->toDateString();
          return $carbonDate->addDays($count)->toDateString();
          break;

        default:
          throw new Exception("Invalid unit. Date increases must be in years, months, weeks, or days.");
          break;
      }
    }


    public function decreaseDate($date, $count, $unit = 'days') {
      if (!$this->validateDate($date) || !(is_int($count) && ((int) $count > 0))) {
        try {
            throw new Exception("Invalid date or count! Please enter a date in a Y-m-d format or use a a positive non zero int for count", 14);
        } catch(Exception $e) {
            echo "The exception code is: " . $e->getCode();
        }
      }
      $count = (int) $count;
      $carbonDate = Carbon::createFromFormat('Y-m-d', $date);

      switch($unit) {
        case 'years':
          if ($count == 1) return $carbonDate->subYear()->toDateString();
          return $carbonDate->subYears($count)->toDateString();
          break;
        case 'months':
         if ($count == 1) return $carbonDate->subMonth()->toDateString();
          return $carbonDate->subMonths($count)->toDateString();
          break;
        case 'weeks':
          if ($count == 1) return $carbonDate->subWeek()->toDateString();
          return $carbonDate->subWeeks($count)->toDateString();
          break;
        case 'days':
          if ($count == 1) return $carbonDate->subDay()->toDateString();
          return $carbonDate->subDays($count)->toDateString();
          break;

        default:
          throw new Exception("Invalid unit. Date increases must be in years, months, weeks, or days.");
          break;
      }
    }

    private function getValidPaydate($date) {
      if (!$this->validateDate($date)) {
        try {
            throw new Exception("Invalid date  Please enter a date in a Y-m-d format.", 15);
        } catch(Exception $e) {
            echo "The exception code is: " . $e->getCode();
        }
      }

      while (!($this->isValidPaydate($date))) {
        //Holiday policy takes precedence
        if ($this->isHoliday($date)) {
          $date = $this->decreateDate($date, 1);

          while ($this->isWeekend($date)) {
            $date = $this->decreaseDate($date, 1);
          }
          continue;
        }

        if ($this->isWeekend($date)) {
          $date = $this->increaseDate($date, 1);

          if ($this->isHoliday($date)) {
            while ($this->isWeekend($date) || $this->isHoliday($date)) {
              $date = $this->decreaseDate($date, 1);
           }
          }
          continue;
        }
    }

    return $date;
  }
}
