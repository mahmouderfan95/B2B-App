<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use  App\Repositories\Admin\QualityTranslationRepository;
class QualityRepository extends BaseRepository
{

    private $qualityTranslationRepository;

    public function __construct(Application $app, QualityTranslationRepository $qualityTranslationRepository)
    {
        parent::__construct($app);

        $this->qualityTranslationRepository = $qualityTranslationRepository;

    }

    public function getAllQualitys(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllQualitiesForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('quality_translations', function ($join) {
            $join->on('qualities.id', '=', 'quality_translations.quality_id');
        })->select('qualities.*')->addSelect('quality_translations.name')
            ->where('quality_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $quality = $this->model->create($data_request);
        if ($quality)
            $this->qualityTranslationRepository->store($data_request['name'], $quality->id);

        return $quality;

    }

    public function update($data_request, $quality_id)
    {
        $quality = $this->model->find($quality_id);
        $quality->update($data_request);
        $qualityTranslation = $this->qualityTranslationRepository->deleteByQualityId($quality->id);
        if ($qualityTranslation)
            $this->qualityTranslationRepository->store($data_request['name'], $quality->id);

        return $quality;

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
     * Quality Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Quality";
    }
}
