@extends('layouts.doctor-app')

@section('content')
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    @include('doctor.sidebar')
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
            <h1 class="text-center wow fadeInUp">Treatment Prescription</h1>

            <form class="main-form" action="{{url('doctor/treatment')}}" method="POST">
                <div class="row mt-5 ">
                    <input type="hidden" name="doctor_id" value="{{Auth::user()->id}}">
                    <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <select name="patient_id" id="patient_id" class="custom-select">
                            <option>--Select Patient--</option>
                            @foreach($patients as $patient)
                            <option value="{{$patient->id}}">{{$patient->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
                        <input name="date" style="background-color:white; color:black; height:50px;" type="date"
                            class="form-control">
                    </div>
                    <div class="col-12 col-sm-6 py-2 wow fadeInRight" data-wow-delay="300ms">
                        <input name="fees" style="background-color:white; color:black; height:50px;" type="number"
                            class="form-control" placeholder="Enter Your Fees">
                    </div>
                    <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <textarea style="background-color:white; color:black;" name="note" id="message"
                            class="form-control" rows="6" placeholder="Enter message.."></textarea>
                    </div>
                    <div class="card-header">
                        <h3 style="float:left;">Medicines</h3> <a href="" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#medicineModal" style="float:right">Add New Medicine</a>
                    </div>
                    <div id="add">

                    </div>
                    <div class="card-body">
                        <table class=" py-2 table table-striped" style="background-color:black; width:80%">
                            <thead>
                                <tr>
                                    <th style="padding:10px; font-size:20px; color:white;">Medicine Name</th>
                                    <th style="padding:10px; font-size:20px; color:white;">Dosage</th>
                                    <th style="padding:10px; font-size:20px; color:white;">Days</th>
                                    <th style="padding-right:0px; font-size:20px; color:white;">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="bodyrow">

                            </tbody>
                            {{--@foreach($treatment->medicines as $medicine)
                            <tr style="background-color:DodgerBlue;" id="mpid{{$medicine->id}}">
                                <td style="padding:10px; color:white;">
                                    {{$medicine->name}}
                                </td>
                                <td style="padding:10px; color:white;">
                                    {{$medicine->pivot->dosage}}
                                </td>
                                <td style="padding:10px; color:white;">
                                    {{$medicine->pivot->days}}
                                </td>
                                <td style="padding-right:0px;">
                                    <a href="javascript:void(0)" onclick="deleteMedicinePrescribed({{$medicine->id}})"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach--}}
                        </table>
                    </div>


                    <div class="card-header my-1">
                        <h3 style="float:left;">Tests</h3> <a href="" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#testModal" style="float:right">Add Test</a>
                    </div>
                    <div id="addTest">

                    </div>
                    <div class="card-body">
                        <table class=" py-2 table table-striped" style="background-color:black; width:80%">
                            <thead>
                                <tr>
                                    <th style="padding:10px; font-size:20px; color:white;">Test Name</th>
                                    <th style="padding:10px; font-size:20px; color:white;">Date</th>
                                    <th style="padding:10px; font-size:20px; color:white;">Amount</th>
                                    <th style="padding-right:0px; font-size:20px; color:white;">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="bodyrowTest">

                            </tbody>

                        </table>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
            </form>
        </div>
    </div>
</div>
<!-- Add Medicine Modal -->
<div class="modal fade" id="medicineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="medicineForm" action="{{url('doctor/try')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="medicine_id" class="form-label">Medicine Name</label>
                        <select name="medicine_id[]" value="{{ old('medicine_id') }}" id="medicine_id"
                            class="custom-select" onchange="medicineSelected()">
                            <option>--Select Medicine--</option>
                            @foreach($medicines as $medicine)
                            <option value="{{$medicine->id}}">{{$medicine->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dosage" class="form-label">Medicine Dosage</label>
                        <input id="dosage" name="dosage[]" value="{{ old('dosage') }}"
                            style="background-color:white; color:black; height:50px;" type="number" class="form-control"
                            placeholder="Enter Medicine Dosage">
                    </div>
                    <div class="mb-3">
                        <label for="days" class="form-label">Medicine Days</label>
                        <input id="days" name="days[]" value="{{ old('days') }}"
                            style="background-color:white; color:black; height:50px;" type="number" class="form-control"
                            placeholder="Enter Days">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Medicine</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Test Modal -->
<div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="testForm">
                    @csrf
                    <div class="mb-3">
                        <input id="test_id" name="test_id[]" value="{{ old('test_id') }}"
                            style="background-color:white; color:black; height:50px;" type="hidden" class="form-control"
                            placeholder="Enter Test Id">
                    </div>
                    <div class="mb-3">
                        <label for="test_name" class="form-label">Test Name</label>
                        <input id="test_name" name="test_name[]" value="{{ old('test_name') }}"
                            style="background-color:white; color:black; height:50px;" type="text" class="form-control"
                            placeholder="Enter Test Name">
                    </div>
                    <div class="mb-3">
                        <label for="test_date" class="form-label">Test Date</label>
                        <input id="test_date" name="test_date[]" value="{{ old('test_date') }}"
                            style="background-color:white; color:black; height:50px;" type="date" class="form-control"
                            placeholder="Enter Test Date">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Test Amount</label>
                        <input id="amount" name="amount[]" value="{{ old('amount') }}"
                            style="background-color:white; color:black; height:50px;" type="number" class="form-control"
                            placeholder="Enter Amount">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Test</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var count = 0;
    var count1=0;
    function medicineSelected() {
        var e = document.getElementById("medicine_id");
        var value = e.value;
        return e.options[e.selectedIndex].text;
    }
    $("#medicineForm").submit(function (e) {
        e.preventDefault();
        let medid =count1++;
        let medicineid = $('#medicine_id').val();
        let medicinename = medicineSelected();
        let dosage = $('#dosage').val();
        let days = $('#days').val();
        $('#add').append(`<div class="medicineids" ><input type="hidden" id=` + `other_medicine_id` + medid + ` name="medicine_id[` + (count1 - 1) + `]" value=` + medicineid + `></div>
        <div class="medicinedosages" ><input type="hidden" id=` + `other_medicine_dosage` + medid + ` name="dosage[` + (count1 - 1) + `]" value=`+ dosage + `></div>
        <div class="medicinedays" ><input type="hidden" id=` + `other_medicine_days` + medid + ` name="days[` + (count1 - 1) + `]" value=`+ days + `></div>`)

        $('#bodyrow').append('<tr style="background-color:DodgerBlue;" id=' + 'mpid' + medicineid + '><td style="padding:10px; color:white;">' + medicinename + '</td><td style="padding:10px; color:white;">' + dosage + '</td><td style="padding:10px; color:white;">' + days + '</td><td style="padding:10px; color:white;"><a href="javascript:void(0)" onclick=deleteMedicinePrescribed(' + medicineid + ','+medid+') class="btn btn-danger">Delete</a></td>');
        $('#medicineForm')[0].reset();
        $('#medicineModal').modal('hide');
    });

    function deleteMedicinePrescribed(id1, id) {
        if (confirm("Do you really want to delete this record?")) {
            $("#mpid" + id1).remove();
            $("#other_medicine_id" + id).remove();
            $("#other_medicine_dosage" + id).remove();
            $("#other_medicine_days" + id).remove();
            var start = false;
            $(".medicineids").each(function (index) {
                $(this).find("input").each(function () {
                    if (index + 1 === id) {
                        start = true;
                    }
                    else if (start === true || id === 0) {
                        var prefix = "medicine_id[" + (index - 1) + "]";
                        this.name = prefix;
                    }
                });
            });
            start = false;
            $(".medicinedosages").each(function (index) {
                $(this).find("input").each(function () {
                    if (index + 1 === id) {
                        start = true;
                    }
                    else if (start === true || id === 0) {
                        var prefix = "dosage[" + (index - 1) + "]";
                        this.name = prefix;
                    }
                });
            });
            start = false;
            $(".medicinedays").each(function (index) {
                $(this).find("input").each(function () {
                    if (index + 1 === id) {
                        start = true;
                    }
                    else if (start === true || id === 0) {
                        var prefix = "days[" + (index - 1) + "]";
                        this.name = prefix;
                    }
                });
            });

            $(".medicineids").each(function(index) {
                $(this).find("input").each(function() {
                    console.log(this.name);
                });
            });
        };
    }

    $("#testForm").submit(function (e) {
        e.preventDefault();
        $('#test_id').val(count++);
        let testid = $('#test_id').val();
        let testname = $('#test_name').val();
        let testdate = $('#test_date').val();
        let amount = $('#amount').val();
        $('#addTest').append(`<div class="testnames" ><input type="hidden" id=` + `other_test_id` + testid + ` name="test_name[` + (count - 1) + `]" value='` + testname + `'></div>
        <div class="testdates" ><input type="hidden" id=` + `other_test_date` + testid + ` name="test_date[` + (count - 1) + `]" value=` + testdate + `></div>
        <div class="testamounts" ><input type="hidden" id=` + `other_amount` + testid + ` name="amount[` + (count - 1) + `]" value=` + amount + `></div>`)
        $('#bodyrowTest').append('<tr style="background-color:DodgerBlue;" id=' + 'tpid' + testid + '><td style="padding:10px; color:white;">' + testname + '</td><td style="padding:10px; color:white;">' + testdate + '</td><td style="padding:10px; color:white;">' + amount + '</td><td style="padding:10px; color:white;"><a href="javascript:void(0)" onclick=deleteTest(' + testid + ') class="btn btn-danger">Delete</a></td>');
        $('#testForm')[0].reset();
        $('#testModal').modal('hide');
    });

    function deleteTest(id) {
        if (confirm("Do you really want to delete this record?")) {
            $("#tpid" + id).remove();

            $("#other_test_id" + id).remove();
            $("#other_test_date" + id).remove();
            $("#other_amount" + id).remove();
            var start = false;
            $(".testnames").each(function (index) {
                $(this).find("input").each(function () {
                    if (index + 1 === id) {
                        start = true;
                    }
                    else if (start === true || id === 0) {
                        var prefix = "test_name[" + (index - 1) + "]";
                        this.name = prefix;
                    }
                });
            });
            start = false;
            $(".testdates").each(function (index) {
                $(this).find("input").each(function () {
                    if (index + 1 === id) {
                        start = true;
                    }
                    else if (start === true || id === 0) {
                        var prefix = "test_date[" + (index - 1) + "]";
                        this.name = prefix;
                    }
                });
            });
            start = false;
            $(".testamounts").each(function (index) {
                $(this).find("input").each(function () {
                    if (index + 1 === id) {
                        start = true;
                    }
                    else if (start === true || id === 0) {
                        var prefix = "amount[" + (index - 1) + "]";
                        this.name = prefix;
                    }
                });
            });

            // $(".testnames").each(function(index) {
            //     $(this).find("input").each(function() {
            //         console.log(this.name);
            //     });
            // });
        };
    }
</script>
@endsection