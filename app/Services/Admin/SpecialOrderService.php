<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\SpecialOrderRequest;
use App\Repositories\Admin\SpecialOrderRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SpecialOrderService
{

    use FileUpload;

    private $specialOrderRepository;
    public function __construct(SpecialOrderRepository $specialOrderRepository)
    {
        $this->specialOrderRepository = $specialOrderRepository;
    }

    /**
     *
     * All  SpecialOrders.
     *
     */
    public function getAllSpecialOrders($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $specialOrders = $this->specialOrderRepository->getAllSpecialOrders($request);
            return view("admin.specialOrders.index", compact('specialOrders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }    /**
     * edit  specialOrders
     */
    public function show($id)
    {
        try {
            $specialOrder = $this->specialOrderRepository->show($id);
            return view("admin.specialOrders.show", compact('specialOrder'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * Delete SpecialOrder.
     *
     * @param int $specialOrder_id
     * @return RedirectResponse
     */
    public function deleteSpecialOrder(int $specialOrder_id): RedirectResponse
    {
        try {
            $specialOrder = $this->specialOrderRepository->show($specialOrder_id);
            if ($specialOrder) {
                $this->specialOrderRepository->destroy($specialOrder_id);
                return redirect()->route('dashboard.specialOrders.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

}
