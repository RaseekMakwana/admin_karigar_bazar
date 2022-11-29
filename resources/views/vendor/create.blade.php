@extends('layouts.default.default')

@section('title', 'Create | Vandor')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-11 mb-0">
                    <h4 class="mb-0">Create Vendor</h4>
                </div>
                <div class="col-sm-1">
                    <a href="{{ url('vendor/manage') }}" class="btn btn-primary btn-block btn-sm">Manage</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">

                @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                    </div>
                @endif

                <form action="{{ url('vendor/store') }}" method="post" name="vendorForm" id="vendorForm"
                    autocomplete="off">
                    @csrf
                    <input type="hidden" name="action" value="{{ $data['vendor_source'] }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor_name">Vendor Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name"
                                    value="{{ (!empty($data['vendor_data']->vendor_name))? $data['vendor_data']->vendor_name : "" }}">
                                <div id="vendor_name_validate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="business_name">Business Name</label>
                                <input type="text" class="form-control" name="business_name" id="business_name"
                                    value="{{ (!empty($data['vendor_data']->business_name))? $data['vendor_data']->business_name : "" }}">
                                <div id="business_name_validate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile_number">Mobile</label>
                                <input type="text" class="form-control" name="mobile_number" id="mobile_number"
                                    maxlength="10" value="{{ (!empty($data['vendor_data']->mobile))? $data['vendor_data']->mobile : "" }}">
                                <div id="mobile_number_validate"></div>
                                <div id="mobile_exist_validate"
                                    style="display: none; color: #eb0000; font-size: 15px; font-weight: normal !important;">
                                    Mobile number is already exist.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select class="form-control select2" name="state" style="width: 100%;" id="state">
                                    <option value="">-- SELECT --</option>
                                    <?php foreach($data['state_data'] as $row){ ?>
                                    <option value="<?php echo $row->state_id; ?>"><?php echo $row->state_name; ?></option>
                                    <?php } ?>
                                </select>
                                <div id="state_validate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select class="form-control select2" name="city" style="width: 100%;" id="city">
                                    <option value="">-- SELECT --</option>
                                </select>
                                <div id="city_validate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filter_area">Area</label>
                                <input type="text" class="form-control" name="area" id="area"
                                    value="{{ (!empty($data['vendor_data']->area))? $data['vendor_data']->area : "" }}">
                                <div id="area_validate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pin_code">Pincode</label>
                                <input type="text" class="form-control" name="pin_code" id="pin_code" maxlength="6"
                                    value="{{ (!empty($data['vendor_data']->pin_code))? $data['vendor_data']->pin_code : "" }}">
                                <div id="pin_code_validate"></div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor_type">Vendor Type</label>
                                <select class="form-control" name="vendor_type" style="width: 100%;" id="vendor_type">
                                    <option value="">-- SELECT --</option>
                                    <?php // foreach($data['vendor_type_data'] as $row){ ?>
                                    <option value="<?php // echo $row->vendor_type_id; ?>"><?php // echo $row->vendor_type_name; ?></option>
                                    <?php // } ?>
                                </select>
                                <div id="vendor_type_validate"></div>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->

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
                vendor_type: 'required',
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
                vendor_type: 'Vendor type is required',
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
            $.ajax({
                "url": '{{ URL('vendor_create_edit/check_vendor_mobile_exist') }}',
                "data": {
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
