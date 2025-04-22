<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class ShippingMethodTranslationRepository extends BaseRepository
{

    public function store($data_request, $shippingMethod_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'shipping_method_id' => $shippingMethod_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByShippingMethodId($shippingMethod_id)
    {
        return $this->model->where('shipping_method_id',$shippingMethod_id)->delete();
    }
    /**
     * ShippingMethod Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\ShippingMethodTranslation";
    }
}
