@extends('layouts.admin-app')

@section('content')
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    {{--@include('admin.navbar')--}}
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" style="padding-top:100px">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="border-color:white;">
                        <div class="card-header" style="border-color:white; font-size:20px; font-weight:bold;">
                            Doctors
                            <a  style="float:right" href="" class="btn btn-danger" id="deleteAllSelectedRecord">Delete Selected</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="background-color:black;" id="doctorTable">
                                <thead>
                                    <tr>
                                        <th style="padding:20px; font-size:18px; color:white;"><input type="checkbox" id="chkCheckAll" /></th>
                                        <th style="padding:20px; font-size:18px; color:white;">Name</th>
                                        <th style="padding:20px; font-size:18px; color:white;">Email</th>
                                        <th style="padding:20px; font-size:18px; color:white;">Speciality</th>
                                        <th style="padding:20px; font-size:18px; color:white;">Image</th>
                                        <th style="padding:20px; font-size:18px; color:white;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:DodgerBlue;">
                                    {{--@foreach($doctors as $doctor)
                                    <tr id="did{{$doctor->id}}">
                                        <td style="padding:15px; color:white;"><input type="checkbox" name="ids" class="checkBoxClass"
                                                value="{{$doctor->id}}" /></td>
                                        <td style="padding:15px; color:white;">{{$doctor->name}}</td>
                                        <td style="padding:15px; color:white;">{{$doctor->email}}</td>
                                        <td style="padding:15px; color:white;">{{$doctor->speciality}}</td>
                                        <td style="padding:15px; color:white;"><img style="height:100px; width:200px" src="../doctorimage/{{$doctor->image}}"/></td>
                                        <td style="padding:15px; color:white;">
                                            <a href="javascript:void(0)" onclick="editDoctor({{$doctor->id}})"
                                                class="btn btn-info">Edit</a>
                                            <a href="javascript:void(0)" onclick="deleteDoctor({{$doctor->id}})"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <!-- Edit Doctor Modal -->
        <div class="modal fade" id="doctorEditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="doctorEditForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input style="color:white;" type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input style="color:white;" type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Speciality</label>
                                <select style="color:white;" id="speciality" name="speciality" class="form-control">
                                    <option>--Select--</option>
                                    <option value="skin">skin</option>
                                    <option value="heart">heart</option>
                                    <option value="eye">eye</option>
                                    <option value="nose">nose</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Doctor Image</label>
                                <input type="file" id="file" name="file" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
        <!-- container-scroller -->
        <!-- <div class="container"-->
        <script>
            $.ajax({
                url: "{{route('doctor.get')}}",
                type: "GET",
                success: function (response) {
                    if (response) {
                        for (var i = 0; i < response.length; i++) {
                            $('#doctorTable tbody').prepend('<tr id=' + 'did' + response[i].id + '><td style="padding:15px; color:white;"><input type="checkbox" name="ids" class="checkBoxClass" value=' + response[i].id + '></td><td style="padding:15px; color:white;">' + response[i].name + '</td><td style="padding:15px; color:white;">' + response[i].email + '</td><td style="padding:15px; color:white;">' + response[i].speciality + '</td><td style="padding:15px; color:white;"><img style="height:100px; width:200px" src="../doctorimage/' + response[i].image + '"/></td><td style="padding:15px; color:white;"><a href="javascript:void(0)" onclick=editDoctor(' + response[i].id + ') class="btn btn-info">Edit</a> <a href="javascript:void(0)" onclick=deleteDoctor(' + response[i].id + ') class="btn btn-danger">Delete</a></td></tr>');
                        }
                    }
                }
            });

            function editDoctor(id) {
                console.log("Entered");
                $.get('/admin/doctors/' + id, function (doctor) {
                    $('#id').val(doctor.id);
                    $('#name').val(doctor.name);
                    $('#email').val(doctor.email);
                    $('#speciality').val(doctor.speciality);
                    $('#file').val("");
                    $("#doctorEditModal").modal('toggle');
                })
            }
            $("#doctorEditForm").submit(function (e) {
                e.preventDefault();
                let id = $('#id').val();
                let name = $('#name').val();
                let email = $('#email').val();
                let speciality = $('#speciality').val();
                let file = $('#file').val();
                let _token = $('input[name=_token]').val();
                let formData = new FormData($('#doctorEditForm')[0]);
                formData.append('_method', 'PUT');
                $.ajax({
                    url: "/admin/doctor",
                    type: "POST",
                    // data: {
                    //     id:id,
                    //     name: name,
                    //     email: email,
                    //     speiality: speciality,
                    //     file:file,
                    //     _token: _token
                    // },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $('#did' + response.id + ' td:nth-child(2)').text(response.name);
                            $('#did' + response.id + ' td:nth-child(3)').text(response.email);
                            $('#did' + response.id + ' td:nth-child(4)').text(response.speciality);
                            $('#did' + response.id + ' td:nth-child(5)').html('<img style="height:100px; width:200px" src="../doctorimage/' + response.image + '"/>');
                            $('#doctorEditModal').modal('toggle');
                            $('#doctorEditForm')[0].reset();
                        }
                    }
                });
            });

            function deleteDoctor(id) {
                if (confirm("Do you really want to delete this record?")) {
                    $.ajax({
                        url: '/admin/doctor/' + id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function (response) {
                            $("#did" + id).remove();
                        }
                    });
                };
            }

            $(function (e) {
                $("#chkCheckAll").click(function () {
                    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                $("#deleteAllSelectedRecord").click(function (e) {
                    e.preventDefault();
                    var allids = [];
                    $("input:checkbox[name=ids]:checked").each(function () {
                        allids.push($(this).val());
                    });
                    $.ajax({
                        url: "{{route('doctor.deleteSelected')}}",
                        type: "DELETE",
                        data: {
                            _token: $("input[name=_token]").val(),
                            ids: allids
                        },
                        success: function (response) {
                            $.each(allids, function (key, val) {
                                $("#did" + val).remove();
                            });
                        }
                    });
                });
            });
        </script>


        @endsection