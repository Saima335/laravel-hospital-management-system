@extends('layouts.admin-app')

@section('content')
    <div class="container-scroller">
      <!-- <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-1">
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div> -->
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      {{--@include('admin.navbar')--}}
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
    
        <div class="container" align="center" style="padding-top:100px" id="messageFirst">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            <form id="doctorForm" enctype="multipart/form-data">
              @csrf
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Doctor Name</label>
                    <input id="name" type="text" required style="background-color:white; color:black; height:40px; width:40%; margin-bottom:15px; padding-left:10px;" name="name" placeholder="Write the name">
                </div>
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Email</label>
                    <input id="email" type="email" required style="background-color:white; color:black; height:40px; width:40%; margin-bottom:15px; padding-left:10px;" name="email" placeholder="Write the email">
                </div>
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Password</label>
                    <input id="password" type="password" required style="background-color:white; color:black; height:40px; width:40%; margin-bottom:15px; padding-left:10px;" name="password" placeholder="Write the password">
                </div>
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Speciality</label>
                    <select id="speciality" name="speciality" required style="background-color:white; color:black; height:40px; width:40%; margin-bottom:15px; padding-left:10px;">
                        <option>--Select--</option>
                        <option value="skin">skin</option>
                        <option value="heart">heart</option>
                        <option value="eye">eye</option>
                        <option value="nose">nose</option>
                    </select>
                </div>
                <div class="col-12 py-2 wow fadeInUp">
                    <label style="width:200px; display:inline-block;">Doctor Image</label>
                    <input style="height:40px; width:40%; margin-bottom:15px; padding-left:10px;" id="file" type="file" required name="file">
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
    $("#doctorForm").submit(function (e) {
                e.preventDefault();
                let name = $('#name').val();
                let email = $('#email').val();
                let speciality = $('#speciality').val();
                let file = $('#file').val();
                let _token = $('input[name=_token]').val();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{route('doctor.addajax')}}",
                    type: "POST",
                    // data: {
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
                          $('#doctorForm')[0].reset();
                          $('#messageFirst').prepend(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Doctor added successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                          `);
                        }
                    }
                });
          });
  </script>
    

@endsection