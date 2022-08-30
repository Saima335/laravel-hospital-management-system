@extends('layouts.doctor-app')

@section('content')
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    @include('doctor.sidebar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" align="center" style="padding-top:100px">
        <div class="container">
            <table class="table table-striped" style="background-color:black; width:100%">
                <tr>
                    <th style="padding:10px; font-size:20px; color:white;">Patient Name</th>
                    <th style="padding:10px; font-size:20px; color:white;">Date</th>
                    <th style="padding:10px; font-size:20px; color:white;">Fees</th>
                    <th style="padding:10px; font-size:20px; color:white;">Note</th>
                    <th colspan="3" style="padding:10px; font-size:20px; color:white; text-align:center">Medicines</th>
                    <!-- <th style="padding-right:0px; font-size:20px; color:white;">Cancel Appointment</th> -->
                </tr>
                @foreach($treatments as $treatment)
                @if($treatment->doctor->id==Auth::user()->id)
                <tr style="background-color:DodgerBlue;">
                    <td style="padding:10px; color:black; font-weight:bold">{{$treatment->patient->name}}</td>
                    <td style="padding:10px; color:white;">{{$treatment->date}}</td>
                    <td style="padding:10px; color:white;">{{$treatment->fees}}</td>
                    <td style="padding:10px; color:white;">{{$treatment->note}}</td>
                    <div>
                        <th style="padding:10px; color:black; font-size:18px;">Medicine Name</th>
                        <th style="padding:10px; color:black; font-size:18px;">Dosage</th>
                        <th style="padding:10px; color:black; font-size:18px;">Days</th>
                @foreach($treatment->medicines as $medicine)
                <tr style="background-color:DodgerBlue;">
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;">{{$medicine->name}}</td>
                    <td style="padding:10px; color:white;">{{$medicine->pivot->dosage}}</td>
                    <td style="padding:10px; color:white;">{{$medicine->pivot->days}}</td>
                </tr>
                @endforeach
                <th style=" background-color: DodgerBlue;padding:10px; color:black; font-size:18px;"></th>
                <th style=" background-color: DodgerBlue;padding:10px; color:black; font-size:18px;"></th>
                <th style=" background-color: DodgerBlue;padding:10px; color:black; font-size:18px;"></th>
                <th style=" background-color: DodgerBlue;padding:10px; color:black; font-size:18px;"></th>
                <th colspan="3"
                    style=" background-color: DodgerBlue;padding:10px; font-size:20px; color:white; text-align:center">
                    Tests</th>
                <tr style="background-color: DodgerBlue;">
                    <th style="padding:10px; color:black; font-size:18px;"></th>
                    <th style="padding:10px; color:black; font-size:18px;"></th>
                    <th style="padding:10px; color:black; font-size:18px;"></th>
                    <th style="padding:10px; color:black; font-size:18px;"></th>
                    <th style="padding:10px; color:black; font-size:18px;">Test Name</th>
                    <th style="padding:10px; color:black; font-size:18px;">Test date</th>
                    <th style="padding:10px; color:black; font-size:18px;">Amount</th>
                </tr>
                @foreach($treatment->laboratorytests as $test)
                <tr style="background-color:DodgerBlue;">
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;"></td>
                    <td style="padding:10px; color:white;">{{$test->name}}</td>
                    <td style="padding:10px; color:white;">{{$test->date}}</td>
                    <td style="padding:10px; color:white;">{{$test->amount}}</td>
                </tr>
                @endforeach
        </div>
        {{--<td style="padding-right:0px;"><a class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this?')"
                href="{{url('patient/cancel_appoint',$appointment->id)}}">Cancel</a></td> --}}
        </tr>
        @endif
        @endforeach
        </table>
    </div>
</div>

@endsection