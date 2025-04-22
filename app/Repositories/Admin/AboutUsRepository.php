<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class AboutUsRepository extends BaseRepository
{

    private $aboutUsTranslationRepository;

    public function __construct(Application $app, AboutUsTranslationRepository $aboutUsTranslationRepository)
    {
        parent::__construct($app);

        $this->aboutUsTranslationRepository = $aboutUsTranslationRepository;

    }

    public function getAllAboutUss(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function store($data_request)
    {
        $aboutUs = $this->model->create($data_request);
        if ($aboutUs)
            $this->aboutUsTranslationRepository->store($data_request['name'], $aboutUs->id);

        return $aboutUs;

    }

    public function update($data_request, $aboutUs_id)
    {
        $aboutUs = $this->model->find($aboutUs_id);
        $aboutUs->update($data_request);
        $aboutUsTranslation = $this->aboutUsTranslationRepository->deleteByAboutUsId($aboutUs->id);
        if ($aboutUsTranslation)
            $this->aboutUsTranslationRepository->store($data_request['name'], $aboutUs->id);

        return $aboutUs;

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
     * AboutUs Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\AboutUs";
    }
}
