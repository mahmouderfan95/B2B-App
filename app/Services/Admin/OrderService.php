<?php

namespace App\Services\Admin;

use App\Events\Orders\UpdateStatus;
use App\Helpers\FileUpload;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Order;
use App\Repositories\Admin\BankRepository;
use App\Repositories\Admin\CountryRepository;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\OrderRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderService
{

    use FileUpload;

    private $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     *
     * All  Orders.
     *
     */
    public function getAllOrders($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $orders = $this->orderRepository->getAllOrders($request);
            return view("admin.orders.index", compact('orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
    /**
     *
     * All  public_orders.
     *
     */
    public function public_orders($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $orders = $this->orderRepository->public_orders($request);
            return view("admin.orders.public", compact('orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Orders.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.orders.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Order.
     *
     * @return RedirectResponse
     */
    public function storeOrder(OrderRequest $request): RedirectResponse
    {

    }

    /**
     * edit  orders
     */
    public function edit($id)
    {

    }

    /**
     * edit  orders
     */
    public function show($id)
    {
        try {
            $order = $this->orderRepository->show($id);
            return view("admin.orders.show", compact('order'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Update Order.
     *
     * @param integer $order_id
     * @param Request $request
     * @return RedirectResponse
     */

    public function updateOrder(OrderRequest $request, int $order_id)

    {
        try{
            $order = Order::Sample()->where('id',$order_id)->update(['status' => $request->status]);
            // send notification to client
            event(new UpdateStatus(Order::find($order_id)));
            return redirect()->route('dashboard.orders.index')->with('success', true);
        }catch(\Exception $exception){
            return redirect()->back()->with(['status' => 'general_error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Delete Order.
     *
     * @param int $order_id
     * @return RedirectResponse
     */
    public function deleteOrder(int $order_id): RedirectResponse
    {
        try {
            $order = $this->orderRepository->show($order_id);
            if ($order) {
                $this->orderRepository->destroy($order_id);
                return redirect()->route('dashboard.orders.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

}
