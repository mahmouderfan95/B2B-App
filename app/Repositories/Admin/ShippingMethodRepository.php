<?php

namespace App\Repositories\Admin;

use App\Models\Language;
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

    public function getAllShippingMethods(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllShippingMethodsForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('shippingMethod_translations', function ($join) {
            $join->on('shippingMethods.id', '=', 'shippingMethod_translations.shippingMethod_id');
        })->select('shippingMethods.*')->addSelect('shippingMethod_translations.name')
            ->where('shippingMethod_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $shippingMethod = $this->model->create($data_request);
        if ($shippingMethod)
            $this->shippingMethodTranslationRepository->store($data_request['name'], $shippingMethod->id);

        return $shippingMethod;

    }

    public function update($data_request, $shippingMethod_id)
    {
        $shippingMethod = $this->model->find($shippingMethod_id);
        $shippingMethod->update($data_request);
        $shippingMethodTranslation = $this->shippingMethodTranslationRepository->deleteByShippingMethodId($shippingMethod->id);
        if ($shippingMethodTranslation)
            $this->shippingMethodTranslationRepository->store($data_request['name'], $shippingMethod->id);

        return $shippingMethod;

    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with('translations')->first();
    }

    public function banned($id)
    {
        $shippingMethod = $this->model->find($id);
        $shippingMethod->banned = $shippingMethod->banned == 0 ? 1 : 0;
        $shippingMethod->save();
        return $shippingMethod;
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
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
