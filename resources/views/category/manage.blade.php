@extends('layouts.default.default')

@section('title', 'Manage | Categories')

@section('page_style')
@stop {{-- @ STYLE SECTION END --}}

@section('content')
    <style>
        .dataTables_filter {
            float: right !important;
        }

        .pagination {
            float: right !important;
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-9 mb-0">
                    <h4 class="mb-0">Manage Categories</h4>
                </div>
                {{-- <div class="col-sm-2">
                    <div class="input-group">
                        <select class="form-control form-control-sm" id="filter_vendor_type">
                            <option value="0">-- SELECT --</option>
                            @foreach ($data['vendor_type_data'] as $row)
                                <option value="{{ $row->vendor_type_id }}"> {{ $row->vendor_type_name }}</option>
                            @endforeach;
                        </select>
                    </div>
                </div> --}}
                <div class="col-sm-1 text-right">
                    <a href="<?php echo URL('category/create'); ?>" class="btn btn-success btn-sm btn-block" id="search_button">Create</a>
                </div>
                <div class="col-sm-1 text-right">
                    <a href="javascript::void(0)" class="btn btn-primary btn-sm btn-block" id="edit_button">Edit</a>
                </div>
                <div class="col-sm-1 text-right">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-block" id="delete_button">Delete</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">

                <table id="manage_datatable" class="table table-hover table-sm" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;">
                                <input type="checkbox" name="checkbox" class="checkbox_2 select_all" value="'.$row->category_id.'">
                            </th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    
                </table>

            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')

    <script>
        $("#delete_button").click(function() {

            var favorite = [];
            $.each($("input[name='checkbox']:checked"), function() {
                favorite.push($(this).val());
            });
            var checked_values = favorite.join(",");

            if (checked_values.length > 0) {
                if (confirm('Are you sure want to remove?')) {
                    $.ajax({
                        "url": '{{ URL('category/delete') }}',
                        "data": {
                            "checked_values": checked_values
                        },
                        "type": "POST",
                        beforeSend: function() {
                            $('#please_wait_loading').show();
                        },
                        success: function(response) {
                            load_master_data();
                        },
                        complete: function() {
                            $("#please_wait_loading").hide();
                        }
                    });
                }
            }


        });
    </script>

    <script>
        load_master_data();
        $("#filter_vendor_type").change(function() {
            load_master_data();
        });

        function load_master_data() {
            var filter_vendor_type = $("#filter_vendor_type").val();

            // $("#edit_button").attr("href", "<?php echo URL('category/edit'); ?>/" + filter_vendor_type);

            var table = $("#manage_datatable").DataTable({
                "bDestroy": true,
                "ajax": {
                    "url": '{{ URL('category/load_manage_data') }}',
                    "data": {
                        "filter_vendor_type": filter_vendor_type
                    },
                    "type": "POST",
                    "dataSrc": "[]",
                },
                "columns": [{
                        'data': 'no'
                    },
                    {
                        'data': 'category_name'
                    },
                    {
                        'data': 'action'
                    }
                ],
                'columnDefs': [ {
                    'targets': [0], /* column index */
                    'orderable': false, /* true or false */
                }]
            });

        }
    </script>

    <script>
        $("#filter_state").change(function() {
            var state_id = $(this).val();
            $.ajax({
                "url": '{{ URL('cosmatic/get_cities_by_state_id') }}',
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
                    $("#filter_city").html(html);
                },
                complete: function() {
                    $("#please_wait_loading").hide();
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select_all').on('click', function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;
                    });
                }
                get_check_edit();
            });

            $(document).on('click', '.checkbox', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('.select_all').prop('checked', true);
                } else {
                    $('.select_all').prop('checked', false);
                }
                get_check_edit();
            });
        });
    </script>

    <script>
        $("#edit_button").click(function(){
            var favorite = [];
            $.each($("input[name='checkbox']:checked"), function() {
                favorite.push($(this).val());
            });
            var checked_values = favorite.join(",");
            window.location.href = "{{ URL('category/edit') }}/"+checked_values;
        });
    </script>

    <script>
        get_check_edit(){
            var favorite = [];
            $.each($("input[name='checkbox']:checked"), function() {
                favorite.push($(this).val());
            });
            var checked_values = favorite.join(",");
            alert(checked_values);
        }
    </script>

@stop {{-- @ JAVASCRIPT SECTION END --}}
