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
        <div class="col-sm-7 mb-0">
          <h4 class="mb-0">Manage Services</h4>
        </div>
        <div class="col-md-2">
            <div class="form-group">
              <select class="form-control form-control-sm" name="filter_category" id="filter_category">
                <option value="0">-- SELECT --</option>
                  @foreach($data['category_data'] as $row)
                      <option value="{{ $row->category_id }}"> {{ $row->category_name }}</option>
                  @endforeach;
              </select>
            </div>
          </div>
        <div class="col-sm-1 text-right">
            <a href="<?php echo URL('service/create') ?>" class="btn btn-success btn-sm btn-block" id="search_button">Create</a>
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
            <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
            <th>Service Name</th>
            <th>Category Name</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
              <th>Service Name</th>
              <th>Category Name</th>
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
$("#delete_button").click(function(){
  
        var favorite = [];
        $.each($("input[name='checkbox']:checked"), function(){
          favorite.push($(this).val());
        });
        var checked_values = favorite.join(",");

        if(checked_values.length > 0){
            if (confirm('Are you sure want to remove?')) {
                  $.ajax({
                    "url": '{{ URL("service/delete") }}',
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
        }
    
    
});
</script>

<script>
load_master_data();
$("#filter_category").change(function(){
  load_master_data();
});

function load_master_data(){
  var filter_category = $("#filter_category").val();

    // $("#edit_button").attr("href","<?php echo URL('service/edit') ?>/"+filter_vendor_type+"/"+filter_category);

    var table = $("#manage_datatable").DataTable({
                  "bDestroy": true,
                  "ajax": {
                      "url": '{{ URL("service/load_manage_data") }}',
                      "data" : {"filter_category": filter_category},
                      "type": "POST",
                      "dataSrc": "[]",
                  },
                  "columns": [
                      {'data': 'no'},
                      {'data': 'service_name'},
                      {'data': 'category_name'},
                      {'data': 'action'},
                  ]
              });
  
}
  
</script>

<script>
  $("#edit_button").click(function(){
      var favorite = [];
      $.each($("input[name='checkbox']:checked"), function() {
          favorite.push($(this).val());
      });
      var checked_values = favorite.join(",");
      window.location.href = "{{ URL('service/edit') }}/"+checked_values;
  });
</script>

<script>
  $("#filter_vendor").change(function() {
    var vendor_type_id = $(this).val();
    $.ajax({
        "url": '{{ URL("cosmatic/get_category_by_vendor_type_id") }}',
        "data": {"vendor_type_id": vendor_type_id},
        "type": "POST",
        beforeSend: function(){
            $('#please_wait_loading').show();
        },
        success: function(response){
            var html = '<option value="">-- SELECT --</option>';
            $.each(response, function(k, val){
                html += '<option value="'+val.category_id+'">'+val.category_name+'</option>';
            });
            $("#filter_category").html(html);
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

@stop {{-- @ JAVASCRIPT SECTION END --}}