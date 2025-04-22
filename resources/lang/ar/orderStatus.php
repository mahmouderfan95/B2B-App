<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::REGISTERD => 'قيد التجهيز',
    OrderStatus::ACCEPTED => 'مقبول من التاجر',
    OrderStatus::IN_DELIVERY => 'جاري التوصيل',
    OrderStatus::DELIVERED => 'تم التوصيل',
    OrderStatus::WAITING_PRICE_VENDOR => ' في انتظار تسعير التاجر',
    OrderStatus::REJECTED => 'مرفوض',
    OrderStatus::COMPLETED => 'مكتمل',
    OrderStatus::CANCELED => 'ملغي',
    OrderStatus::READY_FOR30 => 'جاهز لدفع 30%',
    OrderStatus::PAID30 => 'تم دفع 30%',
    OrderStatus::IN_PROGRESS => 'جاري',
    OrderStatus::READY_TO_SHIP => 'جاهز للشحن',
    OrderStatus::PAID70 => 'تم دفع  70%',
    OrderStatus::SHIPPING_DONE => 'تم الشخن',
    OrderStatus::PAID => 'تم الدفع',
    OrderStatus::IN_SHIPPING => 'جاري الشحن',

    "website" => [
        OrderStatus::REGISTERD   => 'قيد التجهيز',
        OrderStatus::IN_DELIVERY => 'جاري التوصيل',
        OrderStatus::REJECTED    => 'تمت الموافقة',
        OrderStatus::COMPLETED => 'مكتمل',
        OrderStatus::CANCELED => 'ملغي',
        OrderStatus::READY_FOR30 => 'دفع 30%',
        OrderStatus::PAID30 => 'تم دفع 30%',
        OrderStatus::IN_PROGRESS => 'جاري',
        OrderStatus::READY_TO_SHIP => 'جاهز للشحن',
        OrderStatus::PAID70 => 'تم دفع  70%',
        OrderStatus::SHIPPING_DONE => 'تم الشخن',
        OrderStatus::PAID => 'تم الدفع',
        OrderStatus::IN_SHIPPING => 'جاري الشحن',

    ],
];
