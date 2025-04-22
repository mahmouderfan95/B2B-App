<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class UnitRepository extends BaseRepository
{

    private $unitTranslationRepository;

    public function __construct(Application $app, UnitTranslationRepository $unitTranslationRepository)
    {
        parent::__construct($app);

        $this->unitTranslationRepository = $unitTranslationRepository;

    }

    public function getAllUnits(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllUnitsForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('unit_translations', function ($join) {
            $join->on('units.id', '=', 'unit_translations.unit_id');
        })->select('units.*')->addSelect('unit_translations.name')
            ->where('unit_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $unit = $this->model->create($data_request);
        if ($unit)
            $this->unitTranslationRepository->store($data_request['name'], $unit->id);

        return $unit;

    }

    public function update($data_request, $unit_id)
    {
        $unit = $this->model->find($unit_id);
        $unit->update($data_request);
        $unitTranslation = $this->unitTranslationRepository->deleteByUnitId($unit->id);
        if ($unitTranslation)
            $this->unitTranslationRepository->store($data_request['name'], $unit->id);

        return $unit;

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
     * Unit Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Unit";
    }
}
