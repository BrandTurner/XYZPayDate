<?php
// Default timezone is set to America/Los_Angeles in the class constructor.
use Carbon\Carbon;
require 'MyPaydateCalculator.php';

$paydateCalculator = new MyPaydateCalculator();

$firstPaydate = Carbon::now()->toDateString();
$numPaydates = 52; // number of pay dates
$paydateModel = 'WEEKLY';

try {
    print_r($paydateCalculator->calculateNextPaydates($paydateModel, $firstPaydate, $numPaydates));
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
