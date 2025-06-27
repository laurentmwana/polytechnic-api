<?php

use App\Enums\SemesterEnum;

define('QUERY_SEMESTERS', [
    's1' => SemesterEnum::SEMESTER_1->value,
    's2' => SemesterEnum::SEMESTER_2->value,
]);


define('FILTER_ORDERS', ['asc', 'desc']);
