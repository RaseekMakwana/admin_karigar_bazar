@extends('layouts.default.default')

@section('title', 'Manage | Cities')

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
        <div class="col-sm-8 mb-0">
          <h4 class="mb-0">Manage Cities</h4>
        </div>
        <div class="col-sm-2">
          <div class="input-group">
              <select class="form-control form-control-sm" id="filter_state">
                  @foreach($data['state_data'] as $row)
                      <option value="{{ $row->state_id }}">{{ $row->state_name }}</option>
                  @endforeach;
              </select>
          </div>
        </div>
        <div class="col-sm-1 text-right">
            <a href="{{ url('city/create') }}" class="btn btn-success btn-sm btn-block" id="search_button">Create</a>
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
            <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
            <th>City Name</th>
            <th>State Name</th>
            <th style="width: 10%;">Action</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
              <th>City Name</th>
              <th>State Name</th>
              <th style="width: 10%;">Action</th>
            </tr>
          </tfoot>
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
$("#delete_button").click(function(){

    var favorite = [];
    $.each($("input[name='checkbox']:checked"), function(){
      favorite.push($(this).val());
    });
    var checked_values = favorite.join(",");

    $.ajax({
        "url": '{{ URL("city/delete") }}',
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
});
</script>

<script>
load_master_data();
$("#filter_state").change(function(){
  load_master_data();
});

function load_master_data(){
  var filter_state = $("#filter_state").val();
  var table = $("#manage_datatable").DataTable({
                  "bDestroy": true,
                  "ajax": {
                      "url": '{{ URL("city/load_manage_data") }}',
                      "data" : {"filter_state":filter_state},
                      "type": "POST",
                      "dataSrc": "[]",
                  },
                  "columns": [
                      {'data': 'no'},
                      {'data': 'city_name'},
                      {'data': 'state_name'},
                      {'data': 'action'},
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

@stop {{-- @ JAVASCRIPT SECTION END --}}