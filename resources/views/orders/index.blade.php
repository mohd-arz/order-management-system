@extends('layout.app')

@section('title', 'Orders')
@section('orders', 'active')

@section('content')

    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Orders</h1>
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                        <h2>Orders</h2>
                    </div>
                    {{-- <div class="prism-toggle"></div> --}}
                </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Order No</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Ordered By</th>
                                    <th>Ordered At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('orders.getOrders') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'order_no', name: 'order_no' },
                    { data: 'product', name: 'product' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'status', name: 'status' },
                    { data: 'ordered_by', name: 'ordered_by' },
                    { data: 'ordered_at', name: 'ordered_at' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
@endsection