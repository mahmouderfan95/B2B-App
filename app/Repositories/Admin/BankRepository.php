<?php

namespace App\Repositories\Admin;

use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class BankRepository extends BaseRepository
{

    private $bankTranslationRepository;

    public function __construct(Application $app, BankTranslationRepository $bankTranslationRepository)
    {
        parent::__construct($app);

        $this->bankTranslationRepository = $bankTranslationRepository;

    }

    public function getAllBanks(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }
    public function getAllBanksForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->leftJoin('bank_translations', function ($join) {
            $join->on('banks.id', '=', 'bank_translations.bank_id');
        })->select('banks.*')->addSelect('bank_translations.name')
            ->where('bank_translations.language_id', $lang->id)
            ->get();
    }

    public function store($data_request)
    {
        $bank = $this->model->create($data_request);
        if ($bank)
            $this->bankTranslationRepository->store($data_request['name'], $bank->id);

        return $bank;

    }

    public function update($data_request,$bank_id)
    {
        $bank = $this->model->find($bank_id);
        $bank->update($data_request);
        $bankTranslation = $this->bankTranslationRepository->deleteByBankId($bank->id);
        if ($bankTranslation)
            $this->bankTranslationRepository->store($data_request['name'], $bank->id);

        return $bank;

    }

    public function show($id)
    {
        return $this->model->where('id',$id)->with('translations')->first();
    }
    public function destroy($id)
    {
        return $this->model->where('id',$id)->delete();
    }

    /**
     * Bank Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Bank";
    }
}
