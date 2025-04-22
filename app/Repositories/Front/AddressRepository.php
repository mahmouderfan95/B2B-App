<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Language;
use Prettus\Repository\Eloquent\BaseRepository;

class AddressRepository extends BaseRepository
{
    public function getByUserId($client_id)
    {
        $perPage = request()->input('per_page',15);
        return $this->model->where('client_id',$client_id)->paginate($perPage);
    }

    public function setDefault($addres_id)
    {
        $this->model->where('id','!=',$addres_id)
        ->update([
            "is_default" =>0
        ]);

        $this->model->where('id',$addres_id)
        ->update([
            "is_default" =>1
        ]);
        return ;
    }

    /**
     * Product Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\ClientAddress";
    }
}

