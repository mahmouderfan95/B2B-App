<?php

namespace App\Services\SubVendor;

use App\Enums\OrderStatus;
use App\Helpers\FileUpload;
use App\Models\SpecialOrder;
use App\Repositories\Vendor\SpecialOrderRepository;
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
            return view("vendor.specialOrders.index", compact('specialOrders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * edit  specialOrders
     */
    public function show($id)
    {
        try {
            $specialOrder = $this->specialOrderRepository->show($id);
            return view("vendor.specialOrders.show", compact('specialOrder'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    /**
     * edit  specialOrders
     */
    public function acceptedByVendor($id)
    {
        try{
            $specialOrder = SpecialOrder::where('id',$id)->update(['status' => OrderStatus::ACCEPTED]);
            return redirect()->back();
        }catch (\Exception $exception){
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    public function add_total(Request $request)
    {
        try {
            $data_request = $request->all();
            $specialOrder = $this->specialOrderRepository->add_total($data_request);
            return redirect()->route('vendor.orders.special.show',$specialOrder->id)->with('success', true);
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    /**
     * edit  specialOrders
     */
    public function accept(Request $request)
    {
        try {
            $data_request = $request->all();
            $specialOrder = $this->specialOrderRepository->accept($data_request);
            return redirect()->route('vendor.orders.special.show',$specialOrder->id)->with('success', true);
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    /**
     * edit  specialOrders
     */
    public function refused(Request $request)
    {
        try {
            $data_request = $request->all();
            $specialOrder = $this->specialOrderRepository->refused($data_request);
            return redirect()->route('vendor.orders.special.show',$specialOrder->id)->with('success', true);
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    /**
     * edit  specialOrders
     */
    public function shipping_offer_accept(Request $request)
    {
        try {
            $data_request = $request->all();
            $specialOrder = $this->specialOrderRepository->shipping_offer_accept($data_request);
            return redirect()->route('vendor.orders.special.show',$specialOrder->id)->with('success', true);
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    /**
     * edit  specialOrders
     */
    public function shipping_offer_refused(Request $request)
    {
        try {
            $data_request = $request->all();
            $specialOrder = $this->specialOrderRepository->shipping_offer_refused($data_request);
            return redirect()->route('vendor.orders.special.show',$specialOrder->id)->with('success', true);
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
                return redirect()->route('vendor.specialOrders.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

}
