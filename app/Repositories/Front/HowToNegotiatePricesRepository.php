<?php
namespace App\Repositories\Front;
use Prettus\Repository\Eloquent\BaseRepository;
class HowToNegotiatePricesRepository extends BaseRepository{
    public function index()
    {
        return $this->model->with(['translations'])->first();
    }



    /**
     * Language Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\HowToNegotiatePrice";
    }
}
