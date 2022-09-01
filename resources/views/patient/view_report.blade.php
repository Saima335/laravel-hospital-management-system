@extends('layouts.patient-app')

@section('content')
<div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('patient.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper" align="center" style="padding-top:100px">
        <div class="container">
            <table class="table table-striped" style="background-color:black; width:80%">
                <tr>
                    <th style="padding:10px; font-size:20px; color:white;">Test Name</th>
                    <!-- <th style="padding:10px; font-size:20px; color:white;">Patient Name</th> -->
                    <th style="padding:10px; font-size:20px; color:white;">Description</th>
                    <th style="padding:10px; font-size:20px; color:white;">Date</th>
                    <th style="padding:10px; font-size:20px; color:white;">Result</th>
                    <!-- <th style="padding-right:0px; font-size:20px; color:white;">Cancel Appointment</th> -->
                </tr>
                @foreach($laboratoryreports as $laboratoryreport)
                    @if($laboratoryreport->laboratorytest->treatment->patient->id==Auth::user()->id)
                        <tr style="background-color:DodgerBlue;">
                            <td style="padding:10px; color:white;">{{$laboratoryreport->laboratorytest->name}}</td>
                            <!-- <td style="padding:10px; color:white;">{{$laboratoryreport->laboratorytest->treatment->patient->name}}</td> -->
                            <td style="padding:10px; color:white;">{{$laboratoryreport->description}}</td>
                            <td style="padding:10px; color:white;">{{$laboratoryreport->date}}</td>
                            <td style="padding:10px; color:white;">{{$laboratoryreport->result}}</td> 
                            {{-- <td style="padding-right:0px;"><a class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this?')"
                            href="{{url('patient/cancel_appoint',$appointment->id)}}">Cancel</a></td>--}}
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
      </div>
        
@endsection

