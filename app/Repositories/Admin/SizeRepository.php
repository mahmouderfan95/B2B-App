<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class SizeRepository extends BaseRepository
{

    private $sizeTranslationRepository;

    public function __construct(Application $app, SizeTranslationRepository $sizeTranslationRepository)
    {
        parent::__construct($app);

        $this->sizeTranslationRepository = $sizeTranslationRepository;

    }

    public function getAllSizes(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllSizesForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('size_translations', function ($join) {
            $join->on('sizes.id', '=', 'size_translations.size_id');
        })->select('sizes.*')->addSelect('size_translations.name')
            ->where('size_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $size = $this->model->create($data_request);
        if ($size)
            $this->sizeTranslationRepository->store($data_request['name'], $size->id);

        return $size;

    }

    public function update($data_request, $size_id)
    {
        $size = $this->model->find($size_id);
        $size->update($data_request);
        $sizeTranslation = $this->sizeTranslationRepository->deleteBySizeId($size->id);
        if ($sizeTranslation)
            $this->sizeTranslationRepository->store($data_request['name'], $size->id);

        return $size;

    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with('translations')->first();
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Size Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Size";
    }
}
