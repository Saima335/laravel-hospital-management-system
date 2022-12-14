@extends('layouts.admin-app')

@section('content')
    <div class="container-scroller">
      <!-- <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-1">
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div> -->
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      {{--@include('admin.navbar')--}}
        <!-- partial -->
        {{--@include('admin.body')--}}
        {{--@if(Auth::guard('admin')->check())
        Hello {{Auth::guard('admin')->user()->name}}
        @endif
        @if(Auth::guard('web')->check())
        Hello {{Auth::guard('web')->user()->name}}
        @endif
        @if(Auth::guard('patient')->check())
        Hello {{Auth::guard('patient')->user()->name}}
        @endif
        @if(Auth::guard('doctor')->check())
        Hello {{Auth::guard('doctor')->user()->name}}
        @endif
        @if(Auth::guard('laboratory')->check())
        Hello {{Auth::guard('laboratory')->user()->name}}
        @endif--}}
    </div>
    <!-- container-scroller -->
    @include('admin.script')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Hey admin You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->

@endsection
