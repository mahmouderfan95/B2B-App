@extends('layouts.shipping.master')
@section('title')
    @lang('admin.shippingMethods.add_offer')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('shipping.offers.offers')
        @endslot
        @slot('title')
            @lang('shipping.offers.mange')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('shipping.offers.store')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label>@lang('shipping.offers.price')</label>
                            <input class="form-control" name="price">
                        </div>
                        <div class="col-md-6">
                            <label for="order_id">@lang('shipping.offers.code')</label>
                            <select class="form-control" name="order_id" id="order_id">
                                @foreach($orders as $order)
                                    <option value="{{$order->id}}">{{$order->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary">@lang('shipping.offers.save')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
