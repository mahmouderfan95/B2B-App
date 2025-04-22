<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $CURRENT_PAGE   = $this->currentPage();
        $HAS_MORE_PAGES = $this->hasMorePages();
        $LAST_PAGE      = $this->lastPage();
        $TOTAL_RECORDS  = $this->total();
        return [
            'has_more'       => (bool) $HAS_MORE_PAGES,
            'current_page'   => (int)  $CURRENT_PAGE,
            'next_page'      => (int)  $HAS_MORE_PAGES   ? $CURRENT_PAGE + 1 : 0,
            'prev_page'      => (int)  $CURRENT_PAGE > 1 ? $CURRENT_PAGE - 1 : 0,
            'last_page'      => (int)  $LAST_PAGE,
            'total_records'  => (int)  $TOTAL_RECORDS,
        ];
    }
}
