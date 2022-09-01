@extends('layouts.patient-app')

@section('content')
<div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('patient.sidebar')
      <!-- partial -->
      {{--@include('navbar')--}}
        <!-- partial -->
        {{--@include('body')--}}
    </div>
    <!-- container-scroller -->
    {{--@include('script')--}}
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

                    {{ __('Hey Patient You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
