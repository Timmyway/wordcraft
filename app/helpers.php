<?php

use Carbon\Carbon;

if (!function_exists('tim_to_pretty_date')) {
    function tim_to_pretty_date($mysqlDateTime, string $format = 'D MMMM YYYY [à] HH:mm') {

        if (is_null($mysqlDateTime)) {
            return null;
        }

        // Check if the date format contains a 'Z' or microseconds, and handle it accordingly
        try {
            if (strpos($mysqlDateTime, 'Z') !== false) {
                // Assuming the format is ISO 8601 with 'Z' (UTC)
                $userFriendlyDate = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $mysqlDateTime)->isoFormat($format);
            } else {
                // Handle other possible formats, like without microseconds or timezone
                $userFriendlyDate = Carbon::createFromFormat('Y-m-d H:i:s', $mysqlDateTime)->isoFormat($format);
            }
        } catch (\Exception $e) {
            return "Invalid Date Format";
        }

        return $userFriendlyDate;
    }
}
