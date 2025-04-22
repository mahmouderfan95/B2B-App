<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Language;
use App\Models\Review;
use Prettus\Repository\Eloquent\BaseRepository;

class ProductRepository extends BaseRepository
{

    public function getAll($request, $lang)
    {
        $lang = Language::where('code', $lang)->first();
        return $this->model->query()
            ->showable()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                    $query->where('language_id', $lang->id);
                },
                    'type' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    },
                    'unit' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    },
                    'certificates' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    },
                    'quality' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    }, 'vendor', 'product_images']

            )->orderBy('id', 'desc')->get();
    }

    public function best_seller($request, $lang): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', $lang)->first();
        return $this->model->query()
            ->showable()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])->get();
    }

    public function latest($request, $lang): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', $lang)->first();
        return $this->model->query()
            ->showable()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])->orderBy('id', 'desc')->get();
    }

    public function category($request, $lang, $category_id)
    {

        $lang = Language::where('code', $lang)->first();
        return $this->model
            ->CategotyFilter($category_id)
            ->Filtered($request)
            ->showable()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            },
                "category",
                "type",
                "unit",
                "certificates",
                "vendor",
                "product_images",
                "reviews.client",

            ])->withAvg('reviews', 'rate')
            ->withCount('reviews')
            ->orderBy('id', 'desc')
            ->paginate(15);
    }
    public function subCategory($request,$lang,$category_id)
    {
        $lang = Language::where('code', $lang)->first();
        $subCategory = Category::where('id',$category_id)->where('parent_id','!=',null)->first();
        if($subCategory){
            $data = $this->model
            ->where('category_id',$subCategory->id)
            ->Filtered($request)
            ->showable()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            },
                "category",
                "type",
                "unit",
                "certificates",
                "vendor",
                "product_images",
                "reviews.client",

            ])->withAvg('reviews', 'rate')
            ->withCount('reviews')
            ->orderBy('id', 'desc')
            ->paginate(15);
            return $data;
        }
    }

    public function details($request, $lang, $id)
    {
        $lang = Language::where('code', $lang)->first();

        return $this->model->query()
            ->showable()
            ->with(['type' => function ($query) use ($lang) {
                    $query->with(['translations' => function ($q) use ($lang) {
                        $q->where('language_id', $lang->id);
                    }]);
                },
                    'unit' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    },
                    'certificates' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    },
                    'quality' => function ($query) use ($lang) {
                        $query->with(['translations' => function ($q) use ($lang) {
                            $q->where('language_id', $lang->id);
                        }]);
                    }, 'vendor',
                    'product_images',
                    'size',
                    'package',
                    'attributes' => function ($q) use ($lang) {
                        // ->orderBy('attribute_group_id')
                        $q->where('language_id', $lang->id)
                            ->withPivot(['text'])->with(['group' => function ($query) use ($lang) {

                                $query->with(['translations' => function ($query) use ($lang) {
                                    $query->where('language_id', $lang->id);
                                }]);
                            },
                                'translations' => function ($query) use ($lang) {
                                    $query->where('language_id', $lang->id);
                                }
                            ]);
                    }
                ]

            )->where('id', $id)->first();
    }

    public function addreview($data)
    {
        $product = $this->model
            ->showable()->find($data['product_id']);
        if ($product) {
            $review = new Review;
            $review->rate = $data['rate'];
            $review->comment = $data['comment'];
            $review->client_id = auth('client')->id();
            $product->reviews()->save($review);
            return $review;
        }
        return false;
    }

    public function upatereview($data, $review)
    {

        $review->rate = $data['rate'];
        $review->comment = $data['comment'];
        $review->client_id = auth('client')->id();
        $review->save();
        return $review;

    }


    public function currentUserRateProduct($product_id)
    {
        $product = $this->model
            ->showable()->find($product_id);
        $review = $product->reviews()->where('client_id', auth('client')->id())->first();
        if ($review) {
            return $review;
        }
        return false;
    }

    /**
     * Product Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Product";
    }
}

