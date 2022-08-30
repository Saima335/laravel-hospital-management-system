@extends('layouts.admin-app')

@section('content')
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      {{--@include('admin.navbar')--}}
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
    
        <div class="container" align="center" style="padding-top:200px" id="messageFirst">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            <form id="medicineForm" enctype="multipart/form-data">
              @csrf
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Medicine Name</label>
                    <input id="name" type="text" required style="background-color:white; color:black; height:40px; width:40%; margin-bottom:15px; padding-left:10px;" name="name" placeholder="Write the name">
                </div>
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Type</label>
                    <select id="type" name="type" required style="background-color:white; color:black; height:40px; width:40%; margin-bottom:15px; padding-left:10px;">
                        <option>--Select--</option>
                        <option value="drops">drops</option>
                        <option value="injection">injection</option>
                        <option value="tablet">syrup</option>
                        <option value="capsule">capsule</option>
                        <option value="inhalers">inhalers</option>
                    </select>
                </div>
                <div class="col-12 py-2 wow fadeInUp">
                    <input style="height:40px; width:10%; margin-bottom:15px; padding-left:10px;" type="submit" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- container-scroller -->
    {{--@include('admin.script')--}}
<!-- <div class="container"-->
  <script>
    $("#medicineForm").submit(function (e) {
                e.preventDefault();
                let name = $('#name').val();
                let type = $('#type').val();
                let _token = $('input[name=_token]').val();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{route('medicine.addajax')}}",
                    type: "POST",
                    // data: {
                    //     name: name,
                    //     type:type,
                    //     _token: _token
                    // },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response) {
                          $('#medicineForm')[0].reset();
                          $('#messageFirst').prepend(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Medicine added successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                          `);
                        }
                    }
                });
          });
  </script>
    

@endsection