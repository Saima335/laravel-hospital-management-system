@extends('layouts.app')

@section('content')
<div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper" align="center" style="padding-top:100px">
        <div class="container">
            <table class="table table-striped" style="background-color:black; width:80%">
                <tr>
                    <th style="padding:10px; font-size:20px; color:white;">Doctor Name</th>
                    <th style="padding:10px; font-size:20px; color:white;">Date</th>
                    <th style="padding:10px; font-size:20px; color:white;">Time</th>
                    <th style="padding:10px; font-size:20px; color:white;">Description</th>
                    <th style="padding:10px; font-size:20px; color:white;">Status</th>
                    <th style="padding-right:0px; font-size:20px; color:white;">Cancel Appointment</th>
                </tr>
                @foreach($appointments as $appointment)
                    @if($appointment->patient->id==Auth::user()->id)
                        <tr style="background-color:DodgerBlue;">
                            <td style="padding:10px; color:white;">{{$appointment->doctor->name}}</td>
                            <td style="padding:10px; color:white;">{{$appointment->date}}</td>
                            <td style="padding:10px; color:white;">{{$appointment->time}}</td>
                            <td style="padding:10px; color:white;">{{$appointment->description}}</td>
                            <td style="padding:10px; color:white;">{{$appointment->status}}</td> 
                            <td style="padding-right:0px;"><a class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this?')"
                            href="{{url('patient/cancel_appoint',$appointment->id)}}">Cancel</a></td>   
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
      </div>
        
@endsection

