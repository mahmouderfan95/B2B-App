<?php

namespace App\Repositories\Front;

use App\Models\ShippingMethod;
use App\Models\Language;
use App\Models\ShippingOffer;
use App\Models\ShippingSpecialOffer;
use Prettus\Repository\Eloquent\BaseRepository;

class ShippingMethodRepository extends BaseRepository
{


    public function getAllShippingMethods($lang): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return ShippingMethod::query()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])->get();
    }

    public function details($request, $lang, $id): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->query()->where('id', $id)
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])
            ->get();
    }
    public function offer($id): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return ShippingOffer::where('order_id',$id)->all();
    }
    public function special_offer($id): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return ShippingSpecialOffer::where('special_order_id',$id)->get();
    }

    /**
     * ShippingMethod Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\ShippingMethod";
    }
}
