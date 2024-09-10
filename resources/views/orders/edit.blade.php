@extends('layout.app')

@section('title', 'Edit Order')
@section('orders', 'active')

@section('content')

    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Edit Order</h1>
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                            <li class="breadcrumb-item" aria-current="page">Orders</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Order</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                        <h2>Edit Order</h2>
                    </div>
                    {{-- <div class="prism-toggle"></div> --}}
                </div>
                    <div class="card-body">
                      <form action="{{ route('orders.update',$order->id) }}" method="POST" id="update-order-form" data-parsley-validate="true">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-6 my-2">
                              <label for="order_no">Order No</label>
                              <input type="text" name="order_no" class="form-control" placeholder="Order No"
                                  disabled autocomplete="off" value="{{$order->order_no}}" />
                          </div>
                            <div class="col-6 my-2">
                                <label for="product">Product</label>
                                <input type="text" name="product" class="form-control" placeholder="Product"
                                    disabled autocomplete="off" value="{{$order->getProduct->name}}" />
                            </div>
                            <div class="col-6 my-2">
                              <label for="quantity">Quantity</label>
                              <input type="number" name="quantity" class="form-control" placeholder="Quantity" autocomplete="off" disabled value="{{$order->quantity}}" />
                            </div>
                            <div class="col-6 my-2">
                              <label for="status">Status</label>
                              <select name="status_id" class="form-control select-2" id="status">
                                @foreach ($statuses as $status)
                                  <option value="{{$status->id}}" {{ $order->status_id == $status->id ? 'selected' : '' }}>{{$status->name}}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <button type="submit" id="submitbtn" class="btn btn-primary mt-2" style="min-width:85px">
                            <span class="spinner-border spinner-border-sm" style="display: none" id="btn-loader"
                                role="status" aria-hidden="true"></span>
                            <span id="btn-text">Update</span>
                        </button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
          $('.select-2').select2();
          $('#update-order-form').on('submit',function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
              url:$(this).attr('action'),
              type:'POST',
              data:formData,
              contentType:false,
              processData:false,
              success:function(response){
                if(response.success){
                  toastr.success(response.message);
                  window.location.href = response.redirect_url;
                }else{
                  toastr.error(response.message);
                }
              },
              error:function(response){
                toastr.error('Something went wrong');
              }
            });
          });
        });
    </script>
@endsection