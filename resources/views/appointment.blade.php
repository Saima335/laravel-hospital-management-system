@extends('layouts.app')

@section('content')
<div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('sidebar')
      <!-- partial -->
      {{--@include('navbar')--}}
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" align="center" style="padding-top:100px">
        
            <div class="container">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <h1 class="text-center wow fadeInUp">Make an Appointment</h1>

                <form class="main-form" action="{{url('patient/appointment')}}" method="POST">
                    <div class="row mt-5 ">
                        <input type="hidden" name="patient_id" value="{{Auth::user()->id}}">
                        <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
                            <input readonly style="background-color:white; color:black; height:50px;" value="{{Auth::user()->name}}"  type="text" class="form-control" placeholder="Full name">
                        </div>
                        <div class="col-12 col-sm-6 py-2 wow fadeInRight">
                            <input readonly style="background-color:white; color:black; height:50px;" value="{{Auth::user()->email}}" type="text" class="form-control" placeholder="Email address..">
                        </div>
                        <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
                            <input name="date" style="background-color:white; color:black; height:50px;" type="date" class="form-control">
                        </div>
                        <div class="col-12 col-sm-6 py-2 wow fadeInRight" data-wow-delay="300ms">
                            <select name="doctor_id" id="departement" class="custom-select">
                                <option>--Select Doctor--</option>
                                @foreach($doctors as $doctor)
                                <option value="{{$doctor->id}}">{{$doctor->name}}---speciality---{{$doctor->speciality}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                            <input name="time" style="background-color:white; color:black; height:50px;" type="time" class="form-control" placeholder="Enter Time">
                        </div>
                        <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                            <textarea style="background-color:white; color:black;" name="description" id="message" class="form-control" rows="6"
                                placeholder="Enter message.."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
                </form>
            </div>
        </div> 
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

