<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ReviewRequest;
use App\Services\Admin\ReviewService;

class ReviewController extends Controller
{
    public $reviewService;

    /**
     * Review  Constructor.
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->reviewService->getAllReviews($request);
    }

    /**
     * create review page
     */
    public function create()
    {
        return $this->reviewService->create();
    }

    /**
     *  Store Review
     */
    public function store(ReviewRequest $request)
    {

        return $this->reviewService->storeReview($request);
    }

    /**
     * show the review..
     *
     */
    public function show( $id)
    {
        return'dd';
    }

    /**
     * edit the review..
     *
     */
    public function edit(int $id)
    {
        return $this->reviewService->edit($id);

    }

    /**
     * Update the review..
     *
     */
    public function update(ReviewRequest $request, int $id)
    {
        return $this->reviewService->updateReview($request,$id);
    }
    /**
     *
     * Delete Review Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->reviewService->deleteReview($id);

    }

}
