<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\ReviewRequest;
use App\Models\Review;
use App\Repositories\Admin\ReviewRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Helpers\FileUpload;
class ReviewService
{

    use FileUpload;
    private $reviewRepository;
    private $languageRepository;

    public function __construct(ReviewRepository $reviewRepository,LanguageRepository $languageRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Reviews.
     *
     */
    public function getAllReviews($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $reviews  = $this->reviewRepository->getAllReviews($request);
            return view("admin.reviews.index", compact('reviews'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Reviews.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.reviews.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Review.
     *
     * @return RedirectResponse
     */
    public function storeReview(ReviewRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'reviews');

        try {
            $review = $this->reviewRepository->store($data_request);
            if ($review)
                return redirect()->route('dashboard.reviews.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }



    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $review = $this->reviewRepository->show($id);
            return view("admin.reviews.edit",compact('review'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.reviews.index');
        }
    }

    /**
     * Update Review.
     *
     * @param integer $review_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateReview(ReviewRequest $request,int $review_id): RedirectResponse
    {
        $data_request = $request->post('status');
        try {
            $review = $this->reviewRepository->update($data_request,$review_id);
            if ($review)
                return redirect()->route('dashboard.reviews.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Review.
     *
     * @param int $review_id
     * @return RedirectResponse
     */
    public function deleteReview(int $review_id): RedirectResponse
    {
        try {
            $review = $this->reviewRepository->show($review_id);
            if ($review)
            {
                $this->reviewRepository->destroy($review_id);
                return redirect()->route('dashboard.reviews.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
