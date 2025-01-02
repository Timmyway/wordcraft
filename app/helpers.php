<?php

use Carbon\Carbon;

if (!function_exists('tim_to_pretty_date')) {
    function tim_to_pretty_date($mysqlDateTime, string $format = 'D MMMM YYYY [à] HH:mm') {

        if (is_null($mysqlDateTime)) {
            return null;
        }

        try {
            // Preprocess to handle localized format
            $cleanedDateTime = str_replace(' à ', ' ', $mysqlDateTime);

            // Attempt to parse as a standard format
            if (preg_match('/^\d{2} \w+ \d{4} \d{2}:\d{2}$/', $cleanedDateTime)) {
                // Expected format: '25 December 2024 06:24'
                $userFriendlyDate = Carbon::createFromFormat('d F Y H:i', $cleanedDateTime)->isoFormat($format);
            } elseif (strpos($cleanedDateTime, 'T') !== false) {
                // Handle ISO 8601 format
                $userFriendlyDate = Carbon::parse($cleanedDateTime)->isoFormat($format);
            } else {
                // Fallback: Let Carbon handle it
                $userFriendlyDate = Carbon::parse($cleanedDateTime)->isoFormat($format);
            }
        } catch (\Exception $e) {
            // Return error for debugging or logging
            return 'Error parsing date: ' . $e->getMessage();
        }

        return $userFriendlyDate;
    }
}
