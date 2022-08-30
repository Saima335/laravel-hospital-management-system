@extends('layouts.admin-app')

@section('content')
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      {{--@include('admin.navbar')--}}
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
    
            <div class="container" align="center" style="padding-top:100px">
                <table class="table table-striped" style="background-color:black;">
                    <tr>
                        <th style="padding:20px; font-size:20px; color:white;">Customer Name</th>
                        <th style="padding:20px; font-size:20px; color:white;">Email</th>
                        <th style="padding:20px; font-size:20px; color:white;">Doctor Name</th>
                        <th style="padding:20px; font-size:20px; color:white;">Date</th>
                        <th style="padding:20px; font-size:20px; color:white;">Time</th>
                        <th style="padding:20px; font-size:20px; color:white;">Description</th>
                        <th style="padding:20px; font-size:20px; color:white;">Status</th>
                        <th style="padding:20px; font-size:20px; color:white;">Approved</th>
                        <th style="padding:20px; font-size:20px; color:white;">Canceled</th>
                    </tr>
                    @foreach($appointments as $appointment)
                        <tr style="background-color:DodgerBlue;">
                            <td style="padding:15px; color:white;">{{$appointment->patient->name}}</td>
                            <td style="padding:15px; color:white;">{{$appointment->patient->email}}</td>
                            <td style="padding:15px; color:white;">{{$appointment->doctor->name}}</td>
                            <td style="padding:15px; color:white;">{{$appointment->date}}</td>
                            <td style="padding:15px; color:white;">{{$appointment->time}}</td>
                            <td style="padding:15px; color:white;">{{$appointment->description}}</td>
                            <td style="padding:15px; color:white;">{{$appointment->status}}</td> 
                            <td style="padding-right:0px;"><a class="btn btn-success" 
                            href="{{url('admin/approved',$appointment->id)}}">Approved</a></td>
                            <td style="padding-right:0px;"><a class="btn btn-danger" 
                            href="{{url('admin/canceled',$appointment->id)}}">Canceled</a></td> 
                        </tr>
                @endforeach
                </table>
            </div>
        <div>
    </div>
    <!-- container-scroller -->
    @include('admin.script')
<!-- <div class="container"-->
    

@endsection