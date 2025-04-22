<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class TypeRepository extends BaseRepository
{

    private $typeTranslationRepository;

    public function __construct(Application $app, TypeTranslationRepository $typeTranslationRepository)
    {
        parent::__construct($app);

        $this->typeTranslationRepository = $typeTranslationRepository;

    }

    public function getAllTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllTypesForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('type_translations', function ($join) {
            $join->on('types.id', '=', 'type_translations.type_id');
        })->select('types.*')->addSelect('type_translations.name')
            ->where('type_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $type = $this->model->create($data_request);
        if ($type)
            $this->typeTranslationRepository->store($data_request['name'], $type->id);

        return $type;

    }

    public function update($data_request, $type_id)
    {
        $type = $this->model->find($type_id);
        $type->update($data_request);
        $typeTranslation = $this->typeTranslationRepository->deleteByTypeId($type->id);
        if ($typeTranslation)
            $this->typeTranslationRepository->store($data_request['name'], $type->id);

        return $type;

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
     * Type Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Type";
    }
}
