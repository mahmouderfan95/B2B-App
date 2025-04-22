<?php
namespace App\Services\Admin;

use App\Models\FastShipping;
use App\Models\Language;
use Illuminate\Http\Request;

class FastShippingServices{
    public function index()
    {
        $data = FastShipping::with('translations')->get();
        return view('admin.fast_shipping.index',compact('data'));
    }
    public function create()
    {
        $languages  = Language::get();
        return view('admin.fast_shipping.create',compact('languages'));
    }
    public function store(Request $request)
    {
        return $request;
    }

    private function FilterModelData( $request ): array
    {
        foreach ($request as $key => $val) {
            if (is_array($request[$key]))
                unset($request[$key]);
        }
        return $request;
    }
}
