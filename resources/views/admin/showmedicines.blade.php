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
                            Medicines
                            <a  style="float:right" href="" class="btn btn-danger" id="deleteAllSelectedRecord">Delete Selected</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="background-color:black;" id="medicineTable">
                                <thead>
                                    <tr>
                                        <th style="padding:20px; font-size:18px; color:white;"><input type="checkbox" id="chkCheckAll" /></th>
                                        <th style="padding:20px; font-size:18px; color:white;">Name</th>
                                        <th style="padding:20px; font-size:18px; color:white;">Type</th>
                                        <th style="padding:20px; font-size:18px; color:white;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:DodgerBlue;">
                                    {{--@foreach($medicines as $medicine)
                                    <tr id="mid{{$medicine->id}}">
                                        <td style="padding:15px; color:white;"><input type="checkbox" name="ids" class="checkBoxClass"
                                                value="{{$medicine->id}}" /></td>
                                        <td style="padding:15px; color:white;">{{$medicine->name}}</td>
                                        <td style="padding:15px; color:white;">{{$medicine->type}}</td>
                                        <td style="padding:15px; color:white;">
                                            <a href="javascript:void(0)" onclick="editMedicine({{$medicine->id}})"
                                                class="btn btn-info">Edit</a>
                                            <a href="javascript:void(0)" onclick="deleteMedicine({{$medicine->id}})"
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
        <!-- Edit Medicine Modal -->
        <div class="modal fade" id="medicineEditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Medicine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="medicineEditForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" />
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input style="color:white;" type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select style="color:white;" id="type" name="type" class="form-control">
                                    <option>--Select--</option>
                                    <option value="drops">drops</option>
                                    <option value="injection">injection</option>
                                    <option value="tablet">syrup</option>
                                    <option value="capsule">capsule</option>
                                    <option value="inhalers">inhalers</option>
                                </select>
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
                url: "{{route('medicine.get')}}",
                type: "GET",
                success: function (response) {
                    if (response) {
                        for (var i = 0; i < response.length; i++) {
                            $('#medicineTable tbody').prepend('<tr id=' + 'mid' + response[i].id + '><td style="padding:15px; color:white;"><input type="checkbox" name="ids" class="checkBoxClass" value=' + response[i].id+'></td><td style="padding:15px; color:white;">' + response[i].name +'</td><td style="padding:15px; color:white;">' + response[i].type+ '</td><td style="padding:15px; color:white;"><a href="javascript:void(0)" onclick=editMedicine(' + response[i].id + ') class="btn btn-info">Edit</a> <a href="javascript:void(0)" onclick=deleteMedicine(' + response[i].id + ') class="btn btn-danger">Delete</a></td></tr>');
                        }
                    }
                }
            });

            function editMedicine(id) {
                $.get('/admin/medicines/' + id, function (medicine) {
                    $('#id').val(medicine.id);
                    $('#name').val(medicine.name);
                    $('#type').val(medicine.type);
                    $("#medicineEditModal").modal('toggle');
                })
            }
            $("#medicineEditForm").submit(function (e) {
                e.preventDefault();
                let id = $('#id').val();
                let name = $('#name').val();
                let type = $('#type').val();
                let _token = $('input[name=_token]').val();
                var formData = jQuery('#medicineEditForm').serialize();
                $.ajax({
                    url: "{{route('medicine.update')}}",
                    type: "PUT",
                    // data: {
                    //     id:id,
                    //     name: name,
                    //     type:type,
                    //     _token: _token
                    // },
                    data: formData,
                    success: function (response) {
                        if (response) {
                            $('#mid' + response.id + ' td:nth-child(2)').text(response.name);
                            $('#mid' + response.id + ' td:nth-child(3)').text(response.type);
                            $('#medicineEditModal').modal('toggle');
                            $('#medicineEditForm')[0].reset();
                        }
                    }
                });
            });

            function deleteMedicine(id) {
                if (confirm("Do you really want to delete this record?")) {
                    $.ajax({
                        url: '/admin/medicine/' + id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function (response) {
                            $("#mid" + id).remove();
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
                        url: "{{route('medicine.deleteSelected')}}",
                        type: "DELETE",
                        data: {
                            _token: $("input[name=_token]").val(),
                            ids: allids
                        },
                        success: function (response) {
                            $.each(allids, function (key, val) {
                                $("#mid" + val).remove();
                            });
                        }
                    });
                });
            });
        </script>


        @endsection