<?php
namespace App\Services\Payments\Urway;

enum Constants {
    const pending = "pending";
    const completed = "completed";
    const failed = "failed";
    const refund = "refund";
    const currency = "SAR";
    const country = "SA";
    const inquirySuccess = "Successful";// according to urway doc this string will be in result key incase of success

    public static function getStatuses() : array {
        return [
            self::pending,
            self::completed,
            self::failed,
            self::refund,
        ];
    }
}
