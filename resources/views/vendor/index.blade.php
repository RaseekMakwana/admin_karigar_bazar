@extends('layouts.default.default')

@section('title', 'Vandors')

@section('page_style')
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
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
                <div class="col-sm-6 mb-0">
                    <h4 class="mb-0">Manage Vendors</h4>
                </div>
                <div class="col-sm-2 text-right">
                    <div class="input-group">
                        <select class="form-control form-control-sm" id="filter_state">
                            <option value="">-- SELECT STATE --</option>
                            @foreach ($data['state_data'] as $row)
                                <option value="{{ $row->state_id }}">{{ $row->state_name }}</option>
                            @endforeach;
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group">
                        <select class="form-control form-control-sm" id="filter_city">
                            <option value="0">-- SELECT --</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1">
                    <a href="{{ url('vendor/create') }}" class="btn btn-primary btn-block btn-sm"
                        id="search_button">Create</a>
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
                @if( Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                    <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                    </div>
                @endif
                <table id="manage_datatable" class="table table-hover table-sm" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary1" name="checkbox" class="checkbox_2 select_all">
                                    <label for="checkboxPrimary1">
                                    </label>
                                </div>
                            </th>
                            <th style="width: 15%;">Name</th>
                            <th>Mobile</th>
                            <th>Area</th>
                            <th>City</th>
                            <th>State</th>
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

    <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            load_master_data();
            
            $("#filter_state").change(function() {
                load_master_data();
            });

            $("#filter_city").change(function() {
                load_master_data();
            });
        });
        
    </script>
    <script>
        function load_master_data() {
            var filter_state = $("#filter_state").val();
            var filter_city = $("#filter_city").val();
            var table = $("#manage_datatable").DataTable({
                "bDestroy": true,
                "ajax": {
                    "url": '{{ URL("vendor/load_manage_data") }}',
                    "data" : {"filter_state":filter_state, "filter_city": filter_city},
                    "type": "POST",
                    "dataSrc": "[]",
                },
                "columns": [
                    { 'data': 'no' },
                    { 'data': 'vandor_name' },
                    { 'data': 'mobile' },
                    { 'data': 'area_name' },
                    { 'data': 'city_name' },
                    { 'data': 'state_name' },
                    { 'data': 'action' },
                ]
            });
        }
    </script>

<script type="text/javascript">
  $(document).ready(function(){
      $('.select_all').on('click',function(){
          if(this.checked){
              $('.checkbox').each(function(){
                  this.checked = true;
              });
          }else{
               $('.checkbox').each(function(){
                  this.checked = false;
              });
          }
      });
  
      $('.checkbox').on('click',function(){
          if($('.checkbox:checked').length == $('.checkbox').length){
              $('.select_all').prop('checked',true);
          }else{
              $('.select_all').prop('checked',false);
          }
      });
  });
</script>

<script>
$("#delete_button").click(function(){

    if (confirm('Are you sure want to remove?')) {
        var favorite = [];
        $.each($("input[name='checkbox']:checked"), function(){
        favorite.push($(this).val());
        });
        var checked_values = favorite.join(",");

        $.ajax({
            "url": '{{ URL("vendor/delete") }}',
            "data": {"checked_values": checked_values},
            "type": "POST",
            beforeSend: function(){
                $('#please_wait_loading').show();
            },
            success: function(response){
            load_master_data();
            },
            complete: function(){
                $("#please_wait_loading").hide();
            }
        });
    }
});
</script>

<script>
  $("#filter_state").change(function() {
    var state_id = $(this).val();
    $.ajax({
        "url": '{{ URL("cosmatic/get_cities_by_state_id") }}',
        "data": {"state_id": state_id},
        "type": "POST",
        beforeSend: function(){
            $('#please_wait_loading').show();
        },
        success: function(response){
            var html = '<option value="">-- SELECT --</option>';
            $.each(response, function(k, val){
                html += '<option value="'+val['city_id']+'">'+val['city_name']+'</option>';
            });
            $("#filter_city").html(html);
        },
        complete: function(){
            $("#please_wait_loading").hide();
        }
    });
  });
</script>

@stop {{-- @ JAVASCRIPT SECTION END --}}
