<?php

use App\Enums\VendorAgreementEnum;

return [
    'homepage' => [
        'total_public_orders' => 'اجمالى الطلبات العامة',
        'total_sample_orders' => 'اجمالى طلبات العينات',
        'total_products' => 'اجمالى المنتجات',
        'total_sp_orders' => 'اجمالى الطلبات الخاصة',
        'count_of_banks' => 'عدد البنوك',
        'count_of_vendors' => 'عدد التجار',
        'count_of_clients' => 'عدد العملاء',
        'count_of_shipping_method' => 'اجمالى شركات الشحن',
        'latest_sample_order' => 'اخر عينات الطلبات',
        'latest_public_order' => 'اخر الطلبات العامة',
        'latest_sp_order' => 'اخر الطلبات الخاصة',
        'best_selling_product' => 'افضل المنتحات مبيعا',
    ],
    'profile' => [
        'name' => 'اسم المستخدم',
        'avatar' => 'شعار المستخدم',
        'edit' => 'تعديل بيانات المستخدم'
    ],
    "search" => 'بحث',
    "general_error" => "حدث خطأ ما ! برجاء المحاوله مرة اخري",
    "success_message" => "  نجاح ! <br> <br> تمت العملية بنجاح",
    "empty_data" => "لا توجد بيانات!",
    "image" => " الصورة",
    "setting" => "الأعدادات",
    "sort_order" => " الترتيب",
    "status" => " الحالة",
    "banned" => " محظور",
    "restore" => " ارجاع",
    "password" => " كلمة المرور",
    "yes" => " نعم",
    "no" => " لا",
    "phone" => " الموبايل",
    "email" => " البريد الالكتروني",
    "edit" => " تعديل",
    "show" => " مشاهدة",
    "delete" => " حذف",
    "close" => " أغلاق",
    "active" => " مفعل",
    "inactive" => " غير مفعل",
    "pending" => "  جاري",
    "accepted" => "  تم الموافقه",
    "refused" => "  مرفوض",
    "actions" => " تحكم",
    "save" => " حفظ",
    "ban" => " حظر",
    "front_pages" => "محتوي صفحات الموقع",
    "orders_count" => " عدد الطلبات",
    "no_data" => "لا يوجد",
    "general_validation" =>
        [
            "required" => "  هذا الحقل مطلوب",
            "number" => "  هذا الحقل يجب ان يكون رقم",
            "exists" => "  هذا الاختيار غير صحيح ",
            "date" => "  هذا الحقل يجب ان يكون تاريخ",
            "string" => "يجب أن يكون الحقل  من نوع سلسلة نصية",
            "min_2" => "أقل عدد 2 أحرف على الأقل",
            "min_3" => "أقل عدد 3 أحرف على الأقل",
            "name_required" => "  الأسم مطلوب",
            "name_string" => "يجب أن يكون الأسم  من نوع سلسلة نصية",
            "status" => "حقل الحالة مطلوب ",
            "unavailable" => "العنصر غير متوفر",
        ],
    "languages" => [
        'languages' => 'اللغات',
        "manage_languages" => "إدارة اللغات",
        "id" => "معرف اللغة",
        "code" => "كود اللغة",
        "level" => "المستوى",
        "add" => "  أضافة لغة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم اللغة",
        "image" => "   صورة اللغة",
        "image_upload" => "   ارفق صورة اللغة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف لغة؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتناالخاصه باللغة."
        ],
    ],
    "currencies" => [
        'currencies' => 'العملات',
        "manage_currencies" => "إدارة العملات",
        "id" => "معرف العملة",
        "code" => "كود العملة",
        "level" => "المستوى",
        "add" => "  أضافة العملة",
        "value" => "  قيمة العملة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم العملة",
        "image" => "   صورة العملة",
        "image_upload" => "   ارفق صورة العملة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف العملة؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه العملة."
        ],

        "validations" => [
            "name_required" => "إسم العملة  مطلوب",
            "code_required" => "كود العملة  مطلوب",
            "value_required" => "قيمة العملة  مطلوب",
        ]
    ],
    "certificates" => [
        'certificates' => 'الشهادات',
        "manage_certificates" => "إدارة الشهادات",
        "id" => "معرف الشهادة",
        "add" => "  أضافة الشهادة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم الشهادة",
        "image" => "   صورة الشهادة",
        "image_upload" => "   ارفق صورة الشهادة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف الشهادة؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه الشهادة."
        ],

        "validations" => [
            "name_required" => "إسم الشهادة  مطلوب",
        ]
    ],
    "banks" => [
        'banks' => 'البنوك',
        "manage_banks" => "إدارة البنوك",
        "id" => "معرف البنك",
        "add" => "  أضافة البنك",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم البنك",
        "image" => "   صورة البنك",
        "image_upload" => "   ارفق صورة البنك",
        "delete_modal" => [
            "title" => "أنت على وشك حذف البنك؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه البنك."
        ],

        "validations" => [
            "name_required" => "إسم الشهادة  مطلوب",
        ]
    ],
    "banners" => [
        'banners' => 'البنرات',
        "manage_banners" => "إدارة البنرات",
        "id" => "معرف البنر",
        "url" => "رابط البنر",
        "add" => "  أضافة البنر",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم البنر",
        "image" => "   صورة البنر",
        "image_upload" => "   ارفق صورة البنر",
        "delete_modal" => [
            "title" => "أنت على وشك حذف الصوره؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه الصوره."
        ],

        "validations" => [
            "image_required" => "إسم الصوره  مطلوب",
        ]
    ],
    "types" => [
        'types' => 'انواع المنتجات',
        "manage_types" => "إدارة انواع المنتجات",
        "id" => "معرف النوع",
        "add" => "  أضافة النوع",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم النوع",
        "delete_modal" => [
            "title" => "أنت على وشك حذف النوع؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه النوع."
        ],

        "validations" => [
            "name_required" => "إسم النوع  مطلوب",
        ]
    ],
    "attributes" => [
        'attributes' => 'خصائص المنتجات',
        'attributeGroups' => ' مجموعة الخاصية',
        "manage_attributes" => "إدارة خصائص المنتجات",
        "id" => "معرف الخاصية",
        "add" => "  أضافة الخاصية",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم الخاصية",
        "delete_modal" => [
            "title" => "أنت على وشك حذف الخاصية؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه الخاصية."
        ],

        "validations" => [
            "name_required" => "إسم الخاصية  مطلوب",
        ]
    ],
    "attributeGroups" => [
        'attributeGroups' => 'مجموعة خصائص المنتجات ',
        "manage_attributeGroups" => "إدارة  مجموعة خصائص المنتجات",
        "id" => "معرف  مجموعة الخاصية",
        "add" => "  أضافة  مجموعة ",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم  مجموعة الخاصية",
        "delete_modal" => [
            "title" => "أنت على وشك حذف  مجموعة الخاصية؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه ب مجموعة الخاصية."
        ],

        "validations" => [
            "name_required" => "إسم   مجموعة الخاصية  مطلوب",
        ]
    ],
    "units" => [
        'units' => 'وحدات قياس المنتجات',
        "manage_units" => "إدارة وحدات قياس المنتجات",
        "id" => "معرف وحدة قياس",
        "add" => "  أضافة وحدة قياس",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم وحدة القياس",
        "symbol" => "   رمز وحدة القياس",
        "delete_modal" => [
            "title" => "أنت على وشك حذف وحدة القياس؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه وحدة القياس."
        ],

        "validations" => [
            "name_required" => "إسم وحدة القياس  مطلوب",
            "sort_order_required" => "ترتيب وحدة القياس  مطلوب",
            "symbol_required" => "رمز وحدة القياس  مطلوب",
        ]
    ],
    "packages" => [
        'packages' => 'انواع تغليف المنتجات',
        "manage_packages" => "إدارة  انواع تغليف  المنتجات",
        "id" => "معرف  نوع التغليف",
        "add" => "  أضافة   نوع تغليف",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم   نوع التغليف",
        "delete_modal" => [
            "title" => "أنت على وشك حذف  نوع التغليف؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه ب نوع التغليف."
        ],

        "validations" => [
            "name_required" => "إسم   نوع التغليف  مطلوب",
            "sort_order_required" => "ترتيب   نوع التغليف  مطلوب",
        ]
    ],
    "aboutUss" => [
        'aboutUss' => '  منم نحن',
        "manage_aboutUss" => "إدارة من نحن",
        "id" => "معرف  من نحن",
        "add" => "  اضافة محتوى من نحن  ",
        "quick_add" => "  أضافة سريعه",
        "name" => "   وصف    من نحن",
        "delete_modal" => [
            "title" => "أنت على وشك حذف من نحن ؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه ب من نحن ."
        ],

        "validations" => [
            "name_required" => "وصف  من نحن مطلوب",
        ]
    ],
    "sizes" => [
        'sizes' => 'حجم تغليف المنتجات',
        "manage_sizes" => "إدارة  حجم تغليف  المنتجات",
        "id" => "معرف  حجم التغليف",
        "add" => "  أضافة   حجم تغليف",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم   حجم التغليف",
        "delete_modal" => [
            "title" => "أنت على وشك حذف  حجم التغليف؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه ب حجم التغليف."
        ],

        "validations" => [
            "name_required" => "إسم   حجم التغليف  مطلوب",
            "sort_order_required" => "ترتيب   حجم التغليف  مطلوب",
        ]
    ],
    "qualities" => [
        'qualities' => 'جودة  المنتجات',
        "manage_qualities" => "إدارة  جودة المنتجات",
        "id" => "معرف  الجودة",
        "add" => "  أضافة  الجودة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم  الجودة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف الجودة ؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه  بالجودة."
        ],

        "validations" => [
            "name_required" => "إسم  الجودة  مطلوب",
        ]
    ],

    "countries" => [
        'countries_and_regions' => 'الدول والمناطق',
        'countries' => 'الدول',
        "manage_countries" => "إدارة الدول",
        "id" => " ايدي الدولة ",
        "add" => "  أضافة الدولة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم الدولة",
        "vat" => "    ضريبه  القيمة المضافة",
        "code" => "   كود الدولة",
        "image" => "   صورة الدولة",
        "image_upload" => "   ارفق صورة الدولة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف الدولة؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه الدولة."
        ],

        "validations" => [
            "name_required" => "إسم الدولة  مطلوب",
            "code_required" => "كود الدولة  مطلوب",
        ]
    ],
    "regions" => [
        'regions' => 'المناطق',
        "manage_regions" => "إدارة المناطق",
        "id" => "معرف المنطقة",
        "add" => "  أضافة المنطقة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم المنطقة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف المنطقة؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه المنطقة."
        ],

        "validations" => [
            "name_required" => "إسم المنطقة  مطلوب",
            "country_required" => "إسم الدولة  مطلوب",
        ]
    ],
    "cities" => [
        'cities' => 'المدن',
        "manage_cities" => "إدارة المدن",
        "id" => "معرف المدينة",
        "add" => "  أضافة المدينة",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم المدينة",
        "delete_modal" => [
            "title" => "أنت على وشك حذف المدينة؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه المدينة."
        ],

        "validations" => [
            "name_required" => "إسم المدينة  مطلوب",
            "region_required" => "إسم المنطقة  مطلوب",
        ]
    ],
    "categories" => [
        'categories' => 'الأقسام',
        'categories_deleted' => 'الأقسام المحذوفة ',
        "manage_categories" => "إدارة الأقسام",
        "id" => "معرف القسم",
        "main" => "  القسم الرئيسي",
        "name_ar" => "الأسم العربي",
        "name_en" => "الإسم بالأنجليزية",
        "slug_ar" => "رابط القسم بالعربية",
        "slug_en" => "رابط القسم بالأنجليزية",
        "level" => "المستوى",
        "parent_id" => "تابع لقسم",
        "child_count" => " عدد الأقسام",
        "add" => "  أضافة قسم",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم القسم",
        "image" => "   صورة القسم",
        "image_upload" => "   ارفق صورة القسم",
        "validations" => [
            "name_ar_required" => "إسم القسم بالعربي مطلوب",
            "parent_id_numeric" => "معرف القسم الأعلى قيمة رقمية",
            "parent_id_exists" => "قسم غير موجود",
            "image_required" => "حقل صورة القسم مطلوبة",
            "image_image" => "يجب أن يكون الملف من نوع صورة",
            "image_mimes" => "الإمتدادات المقبولة: jpeg,png,jpg,gif,svg",
            "image_max" => "أقصى حجم للصورة هو 2048 KB"
        ]

    ],
    "products" => [
        'products' => 'المنتجات',
        'products_deleted' => 'المنتجات المحذوفة ',
        "manage_products" => "إدارة المنتجات",
        "id" => "معرف المنتج",
        "add" => "  أضافة منتج",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم المنتج",
        "desc" => "   وصف المنتج",
        "organic" => "    عضوي",
        "certificates" => "    الشهادات",
        "price" => "    سعر المنتج",
        "sample_price" => "    سعر عينات للمنتج",
        "sample_order" => "  تفاصيل   عينات المنتج",
        "sample_order_quantity" => "      كمية العينات",
        "image" => "   صورة المنتج",
        "price_from_to" => "   تسعير  المنتج",
        "quantity" => "    الكمية المتاحه",
        "images" => "    صور المنتج",
        "image_upload" => "   ارفق صور المنتج",
        "price_form" => "     السعر يبدأ من",
        "price_to" => "     الى سعر ",
        "weight" => "      الوزن ",
        "length" => "      الطول ",
        "width" => "      العرض ",
        "height" => "      الارتفاع ",
        "entry_attribute" => "      اختار الخاصية ",
        "entry_text" => "      نص الخاصية ",
        "delete_modal" => [
            "title" => "أنت على وشك حذف منتج؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بالمنتج."
        ],
        "validations" => [
        ]

    ],
    "vendors" => [
        'profile' => 'الملف الشخصي',
        'edit_profile' => 'تعديل الملف الشخصي',
        'vendor_shop' => 'المتاجر',
        'vendors' => 'التجار',
        "manage_vendors" => "إدارة التجار والمتاجر",
        "id" => "معرف التاجر",
        "add" => "  أضافة التاجر",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم التاجر",
        "street" => "   عنوان التاجر",
        "bank_account_number" => "    رقم الحساب البنكي",
        "iban" => "    الآيبان",
        "phone" => "    رقم الموبايل",
        "another_phone" => "    رقم موبايل أخر",
        "email" => "    البريد الالكتروني",
        "website" => "    الموقع",
        "description" => "    الوصف",
        "commercial_registration_number" => "    رقم السجل التجاري",
        "expire_date_commercial_registration" => "    تاريخ انتهاء السجل التجاري",
        "image" => "   شعار التاجر",
        "image_commercial" => "   صورة السجل التجاري",
        "image_iban" => "   صورة  الآيبان ",
        "image_mark" => "   صورة علامة التمور السعودية",
        "image_tax" => "   صورة ضريبة القيمة المضافة",
        "image_upload" => "   ارفق صورة التاجر",
        "validations" => [
        ],
        "delete_modal" => [
            "title" => "أنت على وشك حذف متجر؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتناالخاصه متجر."
        ],

    ],
    "shippingMethods" => [
        'shippingMethods' => 'شركات الشحن',
        "manage_shippingMethods" => "إدارة  شركات الشحن",
        "id" => "معرف شركة الشحن",
        "add" => "  أضافة شركة الشحن",
        "quick_add" => "  أضافة سريعه",
        "name" => "   أسم شركة الشحن",
        "image" => "   شعار شركة الشحن",
        'add_offer' => 'اضافة عرض',
        'offer_price' => 'سعر العرض',
        'delivery_fees' => 'رسوم التوصيل',
        "expect_date_from" => "تاريخ التوصيل من",
        "expect_date_to" => "تاريخ التوصيل الى",
        "validations" => [
            "name_required" => "إسم شركة الشحن   مطلوب",

        ],
        "delete_modal" => [
            "title" => "أنت على وشك حذف شركة شحن؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتناالخاصه بشركة الشحن."
        ],

    ],
    "orders" => [
        'orders' => 'الطلبات',
        'orders_sample' => ' طلبات العينات',
        'orders_public' => 'الطلبات العامة',
        'orders_special' => ' الطلبات الخاصة',
        "manage_orders" => "إدارة  الطلبات",
        "show_orders" => " تفاصيل الطلب",
        "order_status" => " حالات الطلب",
        "total_expect" => "   اجمالي الطلب المتوقع",
        "add_total_expect" => " أضف سعر الطلب",
        "order_status_change" => "  تغير حالة الطلب",
        "id" => "معرف الطلب",
        "product_details" => "   تفاصيل المنتج",
        "price_unit" => " سعر الواحد",
        "quantity" => " ألكمية",
        "price_total" => "   الاجمالي",
        "add" => "  أضافة طلب",
        "vendor_name" => "   أسم التاجر",
        "client_name" => "   أسم العميل",
        "client_details" => "    معلومات العميل",
        "shipping_details" => "     عنوان الشحن",
        "payment_details" => "      تفاصيل الدفع",
        "transactions" => "       تحويل رقم # ",
        "products" => "    منتجات الطلب",
        "address" => "     عنوان الشحن ",
        "payment_method" => "      طريقة الدفع ",
        "shipping_method" => "      طريقة الشحن ",
        "date" => "انشاء الطلب",
        "status" => "حالة الطلب",
        "type" => "نوع الطلب",
        "sample" => " طلب عينات",
        "public" => " طلب عادي",
        "vat" => "ضريبة القيمة المضافة",
        "tax" => "الضريبة",
        "sub_total" => "    اجمالي الطلب",
        "total" => "    اجمالي الطلب الكلي",
        "delivery_fees" => "مصاريف الشحن",
        "orderStatus" => [
            "registered" => "قيد التشغيل",
            "in_shipping" => "جارى الشحن",
            "in_delivery" => "جارى التوصيل",
            "paid" => "تم الدفع",
            "completed" => "مكتمل",
            "accepted_by_vendor" => "في انتظار تسعير التاجر",
            "ready_for_30" => "دفع 30%"
        ],
        'created_at' => 'تاريخ الاضافة',
        "validations" => [
        ],
        "delete_modal" => [
            "title" => "أنت على وشك حذف طلب؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتناالخاصه بالطلب."
        ],

    ],

    "quotations" => [
        'quotations' => ' المفاوضات',
        'id' => 'لأي دي',
        'order' => ' رقم الطلب',
        'price' => ' السعر',
        'expect_date_from' => ' من تاريخ',
        'expect_date_to' => ' الى تاريخ',
        'status' => ' حالة الطلب',
        'sender' => '  المرسل',
        'vendors' => '  التاجر',
        'clients' => '  العميل',
        'title' => 'تفاوض جديد',
        'body' => 'تم ارسال تفاوض جديد من مستخدم ',
        'vendor_body' => 'تم الرد على التفاوض من قبل التاجر '
    ],
    "reviews" => [
        'reviews' => 'التقيمات',
        "manage_reviews" => "إدارة التقيمات",
        "id" => "معرف التقيم",
        "rate" => " التقييم",
        "add" => "  أضافة تقيم",
        "quick_add" => "  أضافة سريعه",
        "client" => "   العميل ",
        "product" => "    المنتج",
        "comment" => "    التعليق",
        "delete_modal" => [
            "title" => "أنت على وشك حذف التقييم؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بالتقييم."
        ],

        "validations" => [
            "product_exits" => "   رقم المنتج خطأ",
            "client_exits" => "   رقم العميل خطأ",
        ]
    ],
    "clients" => [
        'clients' => 'العملاء',
        'show_client' => 'تفاصيل العميل',
        'address_client' => 'عناوين شحن  العميل',
        "manage_clients" => "إدارة العملاء",
        "id" => "معرف العميل",
        "name" => " الأسم",
        "phone" => " رقم الموبايل",
        "image" => " صورة العميل ",
        "another_phone" => " رقم موبايل اخر",
        "add" => "  أضافة عميل",
        "quick_add" => "  أضافة سريعه",
        "delete_modal" => [
            "title" => "أنت على وشك حذف العميل؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بالعميل."
        ],
        "validations" => [
            "unique_phone" => "هذا الرقم مستخدم من قبل",
            "unique_email" => "هذا البريد مستخدم من قبل",
        ]
    ],
    "about" => [
        "page_title" => "من نحن",
    ],
    "contacts" => [
        "page_title" => "تواصل معنا",
    ],
    "privacy" => [
        "page_title" => "سياسة الخصوصيه",
    ],
    "fags" => [
        "page_title" => "الاسئله الشائعه",
        "manage_fags" => "أدارة الاسئله الشائعه",
        "id" => "معرف السؤال",
        "question" => "السؤال",
        "answer" => "الأجابه",
        "add" => "اضافة سؤال",
        "edit" => "تعديل السؤال",
        "delete" => "حذف السؤال",
        "delete_modal" => [
            "title" => "أنت على وشك حذف سؤال؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه الاسئله الشائعه."
        ]
    ],
    "privacy_policy" => [
        "page_title" => "سياسة الخصوصية",
        "manage_privacy_policy" => "أدارة سياسة الخصوصية",
        "id" => "معرف سياسة الخصوصية",
        "privacy_policy" => "سياسة الخصوصية",
        "add" => "اضافة سياسة الخصوصية",
        "edit" => "تعديل سياسة الخصوصية",
        "delete" => "حذف سياسة الخصوصية",
        "delete_modal" => [
            "title" => "أنت على وشك حذف سياسة الخصوصية؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بسياسة الخصوصية."
        ]
    ],
    "terms-conditions" => [
        "page_title" => "الشروط و الاحكام",
        "manage_terms-conditions" => "أدارة الشروط و الاحكام",
        "id" => "معرف الشروط و الاحكام",
        "terms-conditions" => "الشروط و الاحكام",
        "add" => "اضافة الشروط و الاحكام",
        "edit" => "تعديل الشروط و الاحكام",
        "delete" => "حذف الشروط و الاحكام",
        "delete_modal" => [
            "title" => "أنت على وشك حذف الشروط و الاحكام",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بالشروط و الاحكام."
        ]
    ],
    "contact" => [
        "page_title" => "تواصل معنا",
        "manage_contact" => "أدارة صفحة تواصل معنا",
        "id" => "المعرف",
        "address" => "العنوان",
        "work_time" => "اوقات العمل",
        "facebook_link" => "عنوان صفحت الفيس بوك",
        "instagram_link" => "عنوان صفحة الانستجرام",
        "twitter_link" => "عنوان صفحة تويتر",
        "whatsapp_link" => "عنوان صفحة الوتس اب",
        "add" => "اضافة معلومات التواصل",
        "edit" => "تعديل معلومات التواصل",
        "delete" => "حذف حذف معلومات التواصل",
        "delete_modal" => [
            "title" => "أنت على وشك حذف معلومات التواصل؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بمعلومات التواصل."
        ]
    ],
    "fast_shipping" => [
        "page_title" => "الشحن السريع",
        "manage_fast_shipping" => "ادارة صفحة الشحن السريع",
        "id" => "المعرف",
        "fast_shipping" => 'محتوى صفحة الشحن السريع',
        "add" => "اضافة محتوى صفحة الشحن السريع",
        "edit" => "تعديل معلومات صحفة الشحن السريع",
        "delete" => "حذف معلومات صفحة الشحن السريع",
        "delete_modal" => [
            "title" => "أنت على وشك حذف معلومات التواصل؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بمعلومات التواصل."
        ]
    ],
    "how-to-special-order" => [
        "page_title" => "كيفية تقديم طلب مميز",
        "manage_fast_shipping" => "ادارة صفحة عمل طلب مميز",
        "id" => "المعرف",
        "fast_shipping" => 'محتوى صفحة عمل طلب مميز',
        "add" => "اضافة محتوى صفحة عمل طلب مميز",
        "edit" => "تعديل معلومات صحفة عمل طلب مميز",
        "delete" => "حذف معلومات صفحة عمل طلب مميز",
        "delete_modal" => [
            "title" => "أنت على وشك حذف معلومات عمل طلب مميز؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بمعلومات عمل طلب مميز."
        ]
    ],
    "how-to-negotiate-price" => [
        "page_title" => "كيفية تقديم عرض سعر",
        "manage_fast_shipping" => "ادارة صفحة عمل عرض سعر",
        "id" => "المعرف",
        "fast_shipping" => 'محتوى صفحة عمل عرض سعر',
        "add" => "اضافة محتوى صفحة عمل عرض سعر",
        "edit" => "تعديل معلومات صحفة عمل عرض سعر",
        "delete" => "حذف معلومات صفحة عمل عرض سعر",
        "delete_modal" => [
            "title" => "أنت على وشك حذف معلومات عمل عرض سعر؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه بمعلومات عمل عرض سعر."
        ]
    ],
    "roles_permissions" => [
        "add" => 'اضافة',
        "edit" => 'تعديل',
        "delete" => 'حذف',
        "page_title" => 'الأدوار والأذونات',
        "roles" => 'الأدوار',
        "permissions" => 'الأذونات',
        "guard_name" => 'اسم الحارس',
    ],
    "transactions" => [
        'transactions_all' => 'المالية والمدفوعات',
        'transactions' => ' المدفوعات',
        "manage_transactions" => "إدارة المدفوعات",
        "id" => "معرف التحويل",
        "client" => "العميل",
        "date" => "التاريخ",
        "status" => "الحالة",
        "total" => "المبلغ ",
        "payment_method" => "طريقة الدفع",
        "code" => "الكود",
        "products_count" => "عدد المنتجات",
        "use_wallet" => "المحفظة ؟",
        "url" => "رابط البنر",
        "add" => "  أضافة البنر",
        "quick_add" => "  أضافة سريعه",
        "image" => "   صورة التحويل",
        "image_upload" => "   ارفق صورة البنر",
        "delete_modal" => [
            "title" => "أنت على وشك حذف التحويل؟",
            "description" => "سيؤدي حذف طلبك إلى إزالة جميع معلوماتك من قاعدة بياناتنا الخاصه التحويل."
        ],

        "validations" => [
            "image_required" => "إسم الصوره  مطلوب",
        ]
    ],

    "settings" => [
        'settings' => 'الاعدات الرئيسية',
        "manage_settings" => "إدارة الاعدات الرئيسية",
        "name" => " اسم الموقع",
        "phone" => " رقم الموبايل",
        "email" => " البريد الالكتروني ",
        "logo" => " اللوجو  ",
        "facebook" => " رابط الفيس بوك  ",
        "twitter" => " رابط تويتر  ",
        "instagram" => " رابط انستجرام  ",
        "linkedin" => " رابط لينكد أن  ",
    ],

    "vendors-agreements" => "إتفاقية التجار",
    "send-vendor-agreement" => "إرسال إتفاقية للتاجر",
    "vendors-agreements-keys" => [
        "select-vendor" => "إختر متجر",
        "select-status" => "إختر حالة الإتفاقية",
        VendorAgreementEnum::PENDING => "تم إرساله فقط",
        VendorAgreementEnum::APPROVED => "تم الموافقة",
        VendorAgreementEnum::CANCELED => "تم الإلغاء من الإدارة",
        "vendor-name" => "إسم المتجر",
        "status" => "حالة الإتفاقية",
        "agreement-pdf" => "رابط الإتفاقية",
        "agreement" => "الإتفاقية",
        "agreement-approved-pdf" => "تحميل الإتفاقية بعد الموافقة",
        "approved-at" => "تاريخ الموافقة",
        "approved-by" => "تم الموافقة بواسطة",
        "download" => "تحميل",
        "cant-cancel-agreement" => "لايمكن إلغاء الإتفاقية لانه تم تعديل حالة الإتفاقية",
        "canceled-agreement" => "تم إلغاء طلب قبول الإتفاقية",
        "cancel-agreement" => "إلغاء طلب الإتفاقية",
        "resend-agreement" => "إعادة إرسال طلب الإتفاقية",
        "resent-agreement" => "تم إعادة أرسال طلب الإتفاقية بنجاح",
        "cant-resend-agreement" => "لايمكن إعادة أرسال طلب الإتفاقية لانه تم تعديل حالة الإتفاقية",
        "send-agreement-success" => "تم إرسال طلب الإتفاقية للمتجر بنجاح",
        "vendor-has-pending-agreement" => "المتجر لديه إتفاقية مرسلة و لم يتم قبولها حتي الآن",
        "agreement-is-pdf" => "Pdf الرجاء إرفاق ملف بصيغة",
        "send" => "إرسال",
        "vendor-sign" => "طرف ثاني",
        "approve-date" => "بتاريخ",
    ],
    "vendorWallets" => [
        'vendorWallets' => 'محافظ التجار',
        'in' => 'إضافة',
        'out' => 'خصم',
        'show_vendorWallet' => 'مشاهدة تحويلات التاجر',
        "all_wallets" => "كل الحسابات",
        "manage_vendorWallets" => "إدارة محافظ   التجار",
        "vendor_wallet_transactions" => "التحويلات",
        "vendor_wallet_id" => "معرف محفظة التاجر",
        "id" => "معرف المحفظة",
        "vendor" => " اسم التاجر",
        "balance" => " الرصيد",
        "shipping_wallet_id" => " معرف المحفظه",
        "user_id" => " بواسطة",
        "amount" => " المبلغ",
        "operation_type" => " نوع العمليه",
        "receipt_url" => " الرابط",
        "reference" => " المرجع",
        "reference_id" => " معرف المرجع",
        "add_balance" => "اضافة رصييد",
        "balance_deduction" => 'خصم رصيد',
        'add' => 'اضافة',
    ],
    "shippingWallets" => [
        'show_shippingWallet' => '   تفاصيل التحويلات الخاصه بالمحفظة',
        'shipping_method' => '  شركة الشحن',
        'shippingWallets' => 'محافظ شركات الشحن',
        "manage_shippingWallets" => "إدارة محافظ  شركات الشحن",
        "shipping_wallet_transactions" => "التحويلات",
        "id" => "معرف المحفظة",
        "balance" => " الرصيد",
        "shipping_wallet_id" => " معرف المحفظه",
        "user_id" => " بواسطة",
        "add_balance" => "اضافة رصييد",
        "balance_deduction" => 'خصم رصيد',
        "amount" => " المبلغ",
        "operation_type" => " نوع العمليه",
        "receipt_url" => " الرابط",
        "reference" => " المرجع",
        "reference_id" => " معرف المرجع",
    ],
    "show-vendor-agreements" => "عرض إتفاقيات المتجر",
    "btn"=>[
        "approve" =>'قبول',
        "reject" =>'رفض',
        "shipping-ready" =>"جاهز للشحن",
        "add" => 'اضافة',
        'deduction' => 'خصم',
        'delivery' => 'تم التوصيل'
    ],
    'user_permissions' => [
        'user_permission' => 'صلاحيات المستخدمين',
        'users' => [
            'users' => 'المستخدمين',
            'id' => 'معرف المستخدم',
            'add' => 'اضافة مستخدم جديد',
            'edit' => 'تعديل المستخدم',
            'delete' => 'حذف المستخدم',
            'name' => 'اسم المستخدم',
            'email' => 'البريد الالكترونى',
            'role_name' => 'نوع المستخدم',
            'password' => 'كلمة السر',
            'roles_name' => 'صلاحية المستخدم',
            'user_roles' => 'ادوار المستخدمين'
        ]
    ],

    'sta_page' => [
        'latest_sp_order' => 'اخر الطلبات الخاصة',
        'order_id' => 'معرف الطلب',
        'clients' => 'العميل',
        'amount' => 'المبلغ',
        'vendor' => 'التاجر',
        'order_status' => 'حالة الطلب',
    ],

    'reports' => [
        "title" => "التقارير",
        "select-vendor" => "إختر متجر",
        "date-from" => "التاريخ من",
        "date-to" => "التاريخ إلي",
        "print" => "طباعة التقرير",
        "excel" => "تصدير التقرير Excel",
        "pdf" => "تنزيل التقرير Pdf",
        "vendors-orders" => [
            "title" => "تقارير طلبات المتاجر",
            "vendor" => "المتجر",
            "order-code" => "كود الطلب",
            "order-id" => "رقم الطلب",
            "created-at" => "تاريخ إنشاء الطلب",
            "delivered-at" => "تاريخ تسليم الطلب",
            "total-without-vat" => "مجموع الطلب بدون VAT",
            "vat-rate" => "قيمة الضريبة",
            "total-with-vat" => "مجموع الطلب مع VAT",
            "company-profit-without-vat" => "عمولة المنصة بدون VAT",
            "company-profit-vat-rate" => "قيمة ضريبة عمولة المنصة",
            "company-profit-with-vat" => "عمولة المنصة مع VAT",
            "vendor-amount" => "اجمالى الطلب",
            "no-orders" => "يرجي تغيير بيانات البحث",
            "sum-total-without-vat" => "مجموع المبيعات بدون VAT",
            "sum-vat-rate" => "قيمة الضريبة",
            "sum-total-with-vat" => "مجموع المبيعات مع VAT",
            "sum-company-profit-without-vat" => "عمولة المنصة بدون VAT",
            "sum-company-profit-vat-rate" => "قيمة ضريبة عمولة المنصة",
            "sum-company-profit-with-vat" => "عمولة المنصة مع VAT",
            "sum-vendor-amount" => "مجموع مستحقات التاجر",
            "print-vendor" => "تقرير مبيعات التاجر الشحنات المستلمة",
            "tax-num" => "الرقم الضريبي: :num",
            "date" => "بتاريخ",
            "page-title" => "تقارير طلبات :type :vendor من :from إلي :to",
            'vat-percentage' => "نسبة VAT (%)",
            'company-profit-vat-percentage' => 'نسبة ربح المنصة (%)',
            'company-profit-vat-applied' => 'نسبة ضريبة عمولة المنصة (%)',
        ],
        "orders-report" => "تقارير الطلبات",
        "total-vendors-orders" => [
            "title" => "تقارير مجموع طلبات المتاجر",
            "vendor" => "المتجر",
            "total-without-vat" => "مجموع الطلبات بدون VAT",
            "vat-rate" => "قيمة الضريبة",
            "total-with-vat" => "مجموع الطلبات مع VAT",
            "company-profit-without-vat" => "عمولة المنصة بدون VAT",
            "company-profit-vat-rate" => "قيمة ضريبة عمولة المنصة",
            "company-profit-with-vat" => "عمولة المنصة مع VAT",
            "vendor-amount" => "الاجمالى",
            "no-orders" => "يرجي تغيير بيانات البحث",
            "print-vendors" => "تقرير مبيعات التجار",
            "tax-num" => "الرقم الضريبي: :num",
            "date" => "بتاريخ",
            "page-title" => "تقارير مجموع طلبات المتاجر :type :vendor من :from إلي :to",
        ],
    ],

    'order-notifications' => [
        'title' => 'طلب جديد',
        'body' => 'تم انشاء طلب جديد يحمل كود',
        'update' => [
            'title' => 'تحديث الطلب',
            'body' => 'تم تحديث حالة الطلب الى ',
        ],
    ],

];
