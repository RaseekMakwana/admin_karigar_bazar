@extends('layouts.default.default')

@section('title', 'Manage | Services')

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
        <div class="col-sm-10 mb-0">
          <h4 class="mb-0">Services: <strong><?php echo $data['vendor_data']->vendor_name; ?></strong></h4>
        </div>
        <div class="col-sm-1 text-right">
            <a href="<?php echo URL('vendor_service/create/'.$data['vendor_data']->user_id) ?>" class="btn btn-success btn-sm btn-block" id="search_button">Create</a>
        </div>
        <div class="col-sm-1 text-right">
            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-block" id="delete_button">Delete</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <input type="hidden" id="hidden_user_id" value="<?php echo $data['vendor_data']->user_id; ?>">
    <!-- Default box -->
    <div class="card">
      <div class="card-body">
        
        <table id="manage_datatable" class="table table-hover table-sm" style="width: 100%">
          <thead>
          <tr>
            <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
            <th>Category Name</th>
            <th>Service Name</th>
            <th>City Name</th>
            <th>State Name</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
              <th>Category Name</th>
              <th>Service Name</th>
              <th>City Name</th>
              <th>State Name</th>
              <th>Action</th>
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
load_master_data();
$("#filter_state").change(function(){
  load_master_data();
});

$("#filter_city").change(function(){
  load_master_data();
});

function load_master_data(){
  var user_id = '<?php echo $data['vendor_data']->user_id ?>';

    var table = $("#manage_datatable").DataTable({
                  "bDestroy": true,
                  "ajax": {
                      "url": '{{ URL("vendor_service/load_manage_data") }}',
                      "data" : {"user_id":user_id},
                      "type": "POST",
                      "dataSrc": "[]",
                  },
                  "columns": [
                      {'data': 'no'},
                      {'data': 'category_name'},
                      {'data': 'services_name'},
                      {'data': 'city_name'},
                      {'data': 'state_name'},
                      {'data': 'action'},
                  ]
              });
  
}
  
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
        var favorite = [];
        $.each($("input[name='checkbox']:checked"), function(){
          favorite.push($(this).val());
        });
        var checked_values = favorite.join(",");
        var hidden_user_id = $("#hidden_user_id").val();

        if(checked_values.length > 0){
            if (confirm('Are you sure want to remove?')) {
                  $.ajax({
                    "url": '{{ URL("vendor_service/delete") }}',
                    "data": {"checked_values": checked_values,"user_id": hidden_user_id},
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
        }
});
</script>

@stop {{-- @ JAVASCRIPT SECTION END --}}