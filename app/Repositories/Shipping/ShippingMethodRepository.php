<?php

namespace App\Repositories\Shipping;

use App\Models\Language;
use App\Repositories\Shipping\ShippingMethodTranslationRepository;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class ShippingMethodRepository extends BaseRepository
{

    private $shippingMethodTranslationRepository;

    public function __construct(Application $app, ShippingMethodTranslationRepository $shippingMethodTranslationRepository)
    {
        parent::__construct($app);

        $this->shippingMethodTranslationRepository = $shippingMethodTranslationRepository;

    }


    public function updateShippingMethod($data_request)
    {
        $shippingMethod = $this->model->find(auth()->user()->id);
        $shippingMethod->update($data_request);
        $shippingMethodTranslation = $this->shippingMethodTranslationRepository->deleteByShippingMethodId($shippingMethod->id);
        if ($shippingMethodTranslation)
            $this->shippingMethodTranslationRepository->store($data_request['name'], $shippingMethod->id);

        return $shippingMethod;

    }

    public function show()
    {
        return $this->model->where('id', auth()->user()->id)->with('translations')->first();
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
