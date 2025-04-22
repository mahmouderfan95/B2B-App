<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\DraftServices;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function __construct(public DraftServices $draftServices)
    {

    }

    public function index()
    {
        return $this->draftServices->getDraftData();
    }
}
