<?php

use Carbon\Carbon;

if (!function_exists('tim_to_pretty_date')) {
    function tim_to_pretty_date($mysqlDateTime, string $format = 'D MMMM YYYY [à] HH:mm') {
        Carbon::setLocale('fr');
        $userFriendlyDate = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $mysqlDateTime)
            ->isoFormat($format);
        return $userFriendlyDate;
    }
}
