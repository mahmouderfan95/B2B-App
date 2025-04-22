<?php

namespace App\Enums;

enum OrderStatus
{
    const REGISTERD = 'registered';
    const WAITING_PRICE_VENDOR = 'waiting_price_vendor';
    const PENDING = 'pending';
    const IN_SHIPPING = 'in_shipping';

    const ACCEPTED = 'accepted_by_vendor';
    const REJECTED = 'rejected_by_vendor';
    const READY_FOR30 = 'ready_for_30';
    const PAID30 = 'paid_30';
    const IN_PROGRESS = 'in_progress';
    const READY_TO_SHIP = 'ready_to_ship';
    const PAID70 = 'paid_70';
    const IN_DELIVERY = 'in_delivery';
    const SHIPPING_DONE = 'shipping_done';
    const DELIVERED = 'delivered';
    const PAID = 'paid';
    const COMPLETED = 'completed';

    const CANCELED = 'canceled';
    const REFUND = 'refund';
    const DELIVERY = 'delivery';

    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::REGISTERD => trans('orderStatus.' . self::REGISTERD),
            self::WAITING_PRICE_VENDOR => trans('orderStatus.' . self::WAITING_PRICE_VENDOR),
            self::PAID => trans('orderStatus.' . self::PAID),
            self::SHIPPING_DONE => trans('orderStatus.' . self::SHIPPING_DONE),
            self::ACCEPTED => trans('orderStatus.' . self::ACCEPTED),
            self::REJECTED => trans('orderStatus.' . self::REJECTED),
            self::IN_DELIVERY => trans('orderStatus.' . self::IN_DELIVERY),
            self::COMPLETED => trans('orderStatus.' . self::COMPLETED),
            self::CANCELED => trans('orderStatus.' . self::CANCELED),
            self::PENDING => trans('orderStatus.' . self::PENDING),
            self::IN_SHIPPING => trans('orderStatus.' . self::IN_SHIPPING),
            self::PAID30 => trans('orderStatus.' . self::PAID30),
            self::IN_PROGRESS => trans('orderStatus.' . self::IN_PROGRESS),
            self::READY_TO_SHIP => trans('orderStatus.' . self::READY_TO_SHIP),
            self::PAID70 => trans('orderStatus.' . self::PAID70),
            self::DELIVERED => trans('orderStatus.' . self::DELIVERED),
        ];
    }

    /**
     * Get wallet status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::REGISTERD => [
                "value" => self::REGISTERD,
                "name" => trans('orderStatus.' . self::REGISTERD),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::WAITING_PRICE_VENDOR => [
                "value" => self::WAITING_PRICE_VENDOR,
                "name" => trans('orderStatus.' . self::WAITING_PRICE_VENDOR),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::PAID => [
                "value" => self::PAID,
                "name" => trans('orderStatus.' . self::PAID),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::SHIPPING_DONE => [
                "value" => self::SHIPPING_DONE,
                "name" => trans('orderStatus.' . self::SHIPPING_DONE),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::ACCEPTED => [
                "value" => self::ACCEPTED,
                "name" => trans('orderStatus.' . self::ACCEPTED),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::REJECTED => [
                "value" => self::REJECTED,
                "name" => trans('orderStatus.' . self::REJECTED),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::IN_DELIVERY => [
                "value" => self::IN_DELIVERY,
                "name" => trans('orderStatus.' . self::IN_DELIVERY),
                "class" => "badge badge-soft-primary text-uppercase"
            ],
            self::COMPLETED => [
                "value" => self::COMPLETED,
                "name" => trans('orderStatus.' . self::COMPLETED),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::PENDING => [
                "value" => self::PENDING,
                "name" => trans('orderStatus.' . self::PENDING),
                "class" => "badge badge-soft-danger text-uppercase"
            ],

            self::IN_SHIPPING => [
                "value" => self::IN_SHIPPING,
                "name" => trans('orderStatus.' . self::IN_SHIPPING),
                "class" => "badge badge-soft-success text-uppercase"
            ],

            self::PAID30 => [
                "value" => self::PAID30,
                "name" => trans('orderStatus.' . self::PAID30),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::IN_PROGRESS => [
                "value" => self::IN_PROGRESS,
                "name" => trans('orderStatus.' . self::IN_PROGRESS),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::READY_TO_SHIP => [
                "value" => self::READY_TO_SHIP,
                "name" => trans('orderStatus.' . self::READY_TO_SHIP),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::READY_FOR30 => [
                "value" => self::READY_FOR30,
                "name" => trans('orderStatus.' . self::READY_FOR30),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::PAID70 => [
                "value" => self::PAID70,
                "name" => trans('orderStatus.' . self::PAID70),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::CANCELED => [
                "value" => self::CANCELED,
                "name" => trans('orderStatus.' . self::CANCELED),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::DELIVERED => [
                "value" => self::DELIVERED,
                "name" => trans('orderStatus.' . self::DELIVERED),
                "class" => "badge badge-soft-success text-uppercase"
            ],
        ];
    }

    /**
     * Get wallet status depending on app locale.
     *
     * @param $status
     * @return string
     */
    public static function getStatus($status): string
    {
        return self::getStatusList()[$status] ?? "";
    }

    /**
     * Get wallet status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(string $status): array
    {
        return self::getStatusListWithClass()[$status] ?? ['class' => '', 'name' => ''];
    }

    public static function getStatuses(): array
    {
        return [
            self::REGISTERD,
            self::WAITING_PRICE_VENDOR,
            self::PAID,
            self::SHIPPING_DONE,
            self::IN_SHIPPING,
            self::ACCEPTED,
            self::REJECTED,
            self::IN_DELIVERY,
            self::COMPLETED,
            self::PENDING,
            self::IN_SHIPPING,
            self::PAID30,
            self::IN_PROGRESS,
            self::READY_TO_SHIP,
            self::SHIPPING_DONE,
            self::DELIVERED
        ];
    }
}
