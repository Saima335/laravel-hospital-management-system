@extends('layouts.laboratory-app')

@section('content')
<div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('laboratory.sidebar')
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
                <h1 class="text-center wow fadeInUp">Make a Report</h1>

                <form class="main-form" action="{{url('laboratory/reports')}}" method="POST">
                    <div class="row mt-5 ">
                        <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
                            <select name="test_id" id="laboratorytest" class="custom-select">
                                <option>--Select Test--</option>
                                @foreach($laboratorytests as $laboratorytest)
                                <option value="{{$laboratorytest->id}}">{{$laboratorytest->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 py-2 wow fadeInRight" data-wow-delay="300ms">
                            <input name="date" style="background-color:white; color:black; height:50px;" type="date" class="form-control">
                        </div>
                        <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
                            @foreach($laboratorytests as $laboratorytest)  
                            <div class="name"  id="name_{{ $laboratorytest->id }}"  style="display:none; background-color:white; border: 1px solid black; border-radius:10px; color:black; height:50px; padding-top:10px; padding-left:10px; text-align: left;">
                                {{ $laboratorytest->treatment->patient->name }}
                            </div>
                            @endforeach
                            <!-- <input id="name" readonly style="background-color:white; color:black; height:50px;" value=""  type="text" class="form-control" placeholder="Full name"> -->
                        </div>
                        <div class="col-12 col-sm-6 py-2 wow fadeInRight">
                            @foreach($laboratorytests as $laboratorytest)  
                            <div class="email"  id="email_{{ $laboratorytest->id }}"  style="display:none; background-color:white; border: 1px solid black; border-radius:10px; color:black; height:50px; padding-top:10px; padding-left:10px; text-align: left;">
                                {{ $laboratorytest->treatment->patient->email }}
                            </div>
                            @endforeach
                            <!-- <input id="email" readonly style="background-color:white; color:black; height:50px;" value="" type="text" class="form-control" placeholder="Email address.."> -->
                        </div>
                        <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                            <textarea style="background-color:white; color:black;" name="description" id="message" class="form-control" rows="6"
                                placeholder="Enter Description..."></textarea>
                        </div>
                        <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                            <input name="result" style="background-color:white; color:black; height:50px;" type="text" class="form-control" placeholder="Enter Result">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
                </form>
            </div>
        </div> 
    </div>
    <script>
        $('#laboratorytest').on('change',function(){
            $(".name").hide();
            var name = $(this).find('option:selected').val();
            $("#name_" + name).show();
            $(".email").hide();
            $("#email_" + name).show();
        });
    </script>
    <!-- container-scroller -->
    {{--@include('script')--}}
<!-- <div class="container"-->
@endsection

