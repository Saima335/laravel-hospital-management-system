@extends('layouts.doctor-app')

@section('content')
<div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('doctor.sidebar')
      <!-- partial -->
      {{--@include('doctor.navbar')--}}
        <!-- partial -->
        {{--@include('doctor.body')--}}
    </div>
    <!-- container-scroller -->
    {{--@include('doctor.script')--}}
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

                    {{ __('Hey Doctor You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
