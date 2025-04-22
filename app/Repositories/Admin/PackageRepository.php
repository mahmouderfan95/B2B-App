<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class PackageRepository extends BaseRepository
{

    private $packageTranslationRepository;

    public function __construct(Application $app, PackageTranslationRepository $packageTranslationRepository)
    {
        parent::__construct($app);

        $this->packageTranslationRepository = $packageTranslationRepository;

    }

    public function getAllPackages(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllPackagesForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('package_translations', function ($join) {
            $join->on('packages.id', '=', 'package_translations.package_id');
        })->select('packages.*')->addSelect('package_translations.name')
            ->where('package_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $package = $this->model->create($data_request);
        if ($package)
            $this->packageTranslationRepository->store($data_request['name'], $package->id);

        return $package;

    }

    public function update($data_request, $package_id)
    {
        $package = $this->model->find($package_id);
        $package->update($data_request);
        $packageTranslation = $this->packageTranslationRepository->deleteByPackageId($package->id);
        if ($packageTranslation)
            $this->packageTranslationRepository->store($data_request['name'], $package->id);

        return $package;

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
     * Package Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Package";
    }
}
