@extends('layout.app')

@section('title', 'Dashboard')
@section('dashboard', 'active')

@section('content')

    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Welcome Admin !</h1>
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-3">
                            <div class="card overflow-hidden" >
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="mt-2">
                                            <h6 class="">Total Orders</h6>
                                            <h2 class="mb-0 number-font">{{$total_orders}}</h2>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="mt-2">
                                            <h6 class="">Total Revenue</h6>
                                            <h2 class="mb-0 number-font">{{$total_revenue}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xl-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex gap-3">
                                        @foreach ($total_orders_by_status as $key => $status)
                                            <div class="mt-2">
                                                <h6 class="">{{$key}}</h6>
                                                <h2 class="mb-0 number-font">{{$status}}</h2>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
