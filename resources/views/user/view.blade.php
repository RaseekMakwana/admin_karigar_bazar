@extends('layouts.default.default')

@section('title', 'View | User')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')
    <?php
    $profile = $data['profile'];
    $vendor = $data['vendor'];
    
    ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 mb-0">
                    <h4 class="mb-0">Profile: {{ $profile->name }}</h4>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <?php $profile_picture = asset('images/user-placeholder.png'); ?>
                                @if (!file_exists(config('app.storage_path') . $profile->profile_picture))
                                    <?php $profile_picture = config('app.storage_url') . $profile->profile_picture; ?>
                                @endif
                                <img class="profile-user-img img-fluid img-circle" src="{{ $profile_picture }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $profile->name }}</h3>

                            <p class="text-muted text-center">{{ $profile->mobile }}</p>

                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <dl class="row ">
                                        <dt class="col-sm-2">Username</dt>
                                        <dd class="col-sm-4">: {{ $profile->name }}</dd>
                                        <dt class="col-sm-2">Mobile</dt>
                                        <dd class="col-sm-4">: {{ $profile->mobile }}</dd>
                                        @if (!empty($profile->birth_date))
                                            <dt class="col-sm-2">Birthdate</dt>
                                            <dd class="col-sm-4">: {{ Helper::dateFormat('d-m-Y', $profile->birth_date) }}
                                            </dd>
                                        @endif
                                        @if (!empty($profile->email))
                                            <dt class="col-sm-2">Email</dt>
                                            <dd class="col-sm-4">: {{ $profile->email }}</dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                    @if (!empty($data['vendor']))
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Vendor Details</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Category</th>
                                            <th>Services</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['vendor_service'] as $row)
                                            <tr>
                                                <td>{{ $row['category_name'] }}</td>
                                                <td>
                                                    @foreach ($row['category_service'] as $service_row)
                                                        <span class="badge bg-warning">
                                                            {{ $service_row['service_name'] }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <b>City: </b> {{ $data['vendor']->city_name }}, <b>State: </b> {{ $data['vendor']->state_name }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')
    <script>
        $("#mobile_number").keyup(function() {
            $("#mobile_exist_validate").hide();
        });
    </script>

    <script>
        $("#state").change(function() {
            var state_id = $(this).val();
            $.ajax({
                "url": '{{ url('cosmatic/get_cities_by_state_id') }}',
                "data": {
                    "state_id": state_id
                },
                "type": "POST",
                beforeSend: function() {
                    $('#please_wait_loading').show();
                },
                success: function(response) {
                    var html = '<option value="">-- SELECT --</option>';
                    $.each(response, function(k, val) {
                        html += '<option value="' + val['city_id'] + '">' + val['city_name'] +
                            '</option>';
                    });
                    $("#city").html(html);
                },
                complete: function() {
                    $("#please_wait_loading").hide();
                }
            });
        });

        $("#city").change(function() {
            var city_id = $(this).val();
            $.ajax({
                "url": '{{ URL('cosmatic/get_area_by_city_id') }}',
                "data": {
                    "city_id": city_id
                },
                "type": "POST",
                beforeSend: function() {
                    $('#please_wait_loading').show();
                },
                success: function(response) {
                    var html = '<option value="">-- SELECT --</option>';
                    $.each(response, function(k, val) {
                        html += '<option value="' + val['area_id'] + '">' + val['area_name'] +
                            '</option>';
                    });
                    $("#area").html(html);
                },
                complete: function() {
                    $("#please_wait_loading").hide();
                }
            });
        });
    </script>


    <script type="text/javascript">
        $('form[id="vendorForm"]').validate({
            rules: {
                vendor_name: 'required',
                business_name: 'required',
                mobile_number: {
                    required: true,
                    number: true,
                    minlength: 10
                },
                password: 'required',
                state: 'required',
                city: 'required',
                area: 'required',
                pin_code: {
                    required: true,
                    number: true,
                    minlength: 6
                },
                // "services[]": "required"
            },
            messages: {
                vendor_name: 'Vendor name is required',
                business_name: 'Business name is required',
                mobile_number: {
                    required: 'Mobile is required',
                },
                password: 'Password is required',
                state: 'State is required',
                city: 'City is required',
                area: 'Area is required',
                pin_code: {
                    required: 'Pincode is required',
                },
                // "services[]": "Target services are required"
            },
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");
                var $obj = $("#" + name + "_validate");
                error.appendTo($obj);
            },
            submitHandler: function(form) {

                checkMobileExist(form);

                // login_verification();
            }
        });


        function checkMobileExist(form) {
            var mobile_number = $('#mobile_number').val();
            var user_id = $('#user_id').val();
            $.ajax({
                "url": '{{ URL('vendor_create_edit/check_vendor_mobile_exist') }}',
                "data": {
                    "user_id": user_id,
                    "mobile_number": mobile_number
                },
                "type": "POST",
                beforeSend: function() {
                    $('#please_wait_loading').show();
                },
                success: function(response) {
                    if (response == 1) {
                        $("#mobile_exist_validate").show();
                    } else {
                        form.submit();
                    }
                },
                complete: function() {
                    $("#please_wait_loading").hide();
                }
            });
        }
    </script>

@stop {{-- @ JAVASCRIPT SECTION END --}}
