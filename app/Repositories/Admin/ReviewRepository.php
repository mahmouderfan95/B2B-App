<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class ReviewRepository extends BaseRepository
{


    public function getAllReviews(): array|\Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['product','client'])->get();
    }

    public function store($data_request)
    {
        $review = $this->model->create($data_request);
        if ($review)
            return $review;

        return false;
    }

    public function update($data_request, $review_id)
    {
        $review = $this->model->find($review_id);
        $review->update($data_request);
        return $review;
    }

    public function show($id)
    {
        return $this->model->where('id',$id)->with(['product','client'])->first();
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Review Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Review";
    }
}
