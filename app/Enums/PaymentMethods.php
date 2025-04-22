<?php

namespace App\Enums;

enum PaymentMethods {
    /**
     * the pay method is cash.
     */
    public const Bank = 1;

    /**
     * the pay method is visa.
     */
    public const VISA = 2;

    /**
     * the whole arder wallet.
     */
    public const WALLET = 3;

    /**
     * Get wallet attachments status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::Bank => trans('admin.customer_finances.payment_methods.cash'),
            self::VISA => trans('admin.customer_finances.payment_methods.visa'),
            self::WALLET => trans('admin.customer_finances.payment_methods.wallet')
        ];
    }

    /**
     * Get wallet attachments status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::Bank => [
                "value" => self::Bank,
                "name" => trans('admin.customer_finances.payment_methods.cash'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::VISA => [
                "value" => self::VISA,
                "name" => trans('admin.customer_finances.payment_methods.visa'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::WALLET => [
                "value" => self::WALLET,
                "name" => trans('admin.customer_finances.payment_methods.wallet'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
        ];
    }

    /**
     * Get wallet attachment status depending on app locale.
     *
     * @param bool $is_has_attachment
     * @return string
     */
    public static function getStatus(int $status_id): string
    {
        return self::getStatusList()[$status_id];
    }

    /**
     * Get wallet attachment status with class color depending on app locale.
     *
     * @param int $is_has_attachment
     * @return array
     */
    public static function getStatusWithClass(int $status_id): array
    {
        return self::getStatusListWithClass()[$status_id];
    }

    public static function getPayments() : array {
        return [
            self::Bank,
            self::WALLET,
            self::VISA
        ];
    }

    /**
     * @param [type] $payment
     * @return string
     */
    public static function paymentEnglishName($payment) : string {
        return match($payment) {
            self::Bank => "Cash",
            self::WALLET => "Customer Wallet",
            self::VISA => "Visa",
            default => "Unkown"
        };
    }
}
