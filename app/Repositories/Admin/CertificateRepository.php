<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class CertificateRepository extends BaseRepository
{

    private $certificateTranslationRepository;

    public function __construct(Application $app, CertificateTranslationRepository $certificateTranslationRepository)
    {
        parent::__construct($app);

        $this->certificateTranslationRepository = $certificateTranslationRepository;

    }

    public function getAllCertificates(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllCertificatesForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('certificate_translations', function ($join) {
            $join->on('certificates.id', '=', 'certificate_translations.certificate_id');
        })->select('certificates.*')->addSelect('certificate_translations.name')
            ->where('certificate_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $certificate = $this->model->create($data_request);
        if ($certificate)
            $this->certificateTranslationRepository->store($data_request['name'], $certificate->id);

        return $certificate;

    }

    public function update($data_request, $certificate_id)
    {
        $certificate = $this->model->find($certificate_id);
        $certificate->update($data_request);
        $certificateTranslation = $this->certificateTranslationRepository->deleteByCertificateId($certificate->id);
        if ($certificateTranslation)
            $this->certificateTranslationRepository->store($data_request['name'], $certificate->id);

        return $certificate;

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
     * Certificate Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Certificate";
    }
}
