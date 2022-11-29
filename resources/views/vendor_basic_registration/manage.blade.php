@extends('layouts.default.default')

@section('title', 'Manage | Vendor Registration')

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
                <div class="col-sm-5 mb-0">
                    <h4 class="mb-0">Vendor Registration</h4>
                </div>

                <div class="col-sm-1 text-right" id="approve_button_action">
                  <a href="javascript:void(0)" class="btn btn-success btn-sm btn-block" id="approve_button">Approve</a>
                </div>
                <div class="col-sm-1 text-right" id="reject_button_action">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-block" id="reject_button">Reject</a>
                </div>
                <div class="col-sm-1 text-right" id="delete_button_action">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-block" id="delete_button">Delete</a>
                </div>
                <div class="col-sm-2 text-right">
                  <div class="input-group">
                      <select class="form-control form-control-sm" id="filter_action">
                          <option value="">-- SELECT --</option>
                          <option value="1" selected>New</option>
                          <option value="2">Completed</option>
                          <option value="3">Rejected</option>
                      </select>
                  </div>
              </div>

                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="date" class="form-control form-control-sm" id="filter_date">
                    </div>
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
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                    </div>
                @endif
                <table id="manage_datatable" class="table table-hover table-sm" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
                            <th style="width: 15%;">Name</th>
                            <th>Mobile</th>
                            <th>Occupation</th>
                            <th>Area</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width: 5%;"><input type="checkbox" class="checkbox_2 select_all" /></th>
                            <th style="width: 15%;">Name</th>
                            <th>Mobile</th>
                            <th>Occupation</th>
                            <th>Area</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="card-footer text-center">
              <div class="row footer_progress_status_icons_color">
              <div class="col-md-2">
                <i class="fa fa-circle" style="color: Blue"></i> New
              </div>
                <div class="col-md-2">
                  <i class="fa fa-circle" style="color: green"></i> Completed
              </div>
              <div class="col-md-2">
                <i class="fa fa-circle" style="color: red"></i> Rejected
              </div>
            </div>
          </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')

    
    <script>
        $(document).ready(function(){
            load_master_data();
            
            $("#filter_action").change(function() {
                load_master_data();
            });

            $("#filter_date").change(function() {
                load_master_data();
            });
        });
        
    </script>
    <script>
        function load_master_data() {
            var filter_action = $("#filter_action").val();
            var filter_date = $("#filter_date").val();
            var table = $("#manage_datatable").DataTable({
                "bDestroy": true,
                "ajax": {
                    "url": '{{ URL("vendor_basic_registration/load_manage_data") }}',
                    "data" : {"filter_action":filter_action, "filter_date": filter_date},
                    "type": "POST",
                    "dataSrc": "[]",
                },
                "columns": [
                    { 'data': 'no' },
                    { 'data': 'vendor_name' },
                    { 'data': 'mobile' },
                    { 'data': 'occupation' },
                    { 'data': 'area_name' },
                    { 'data': 'city_name' },
                    { 'data': 'state_name' },
                    { 'data': 'created_at' },
                    { 'data': 'action' },
                ]
            });
        }
    </script>

<script>

  $(document).on("click",".view_detail",function(){
    var user_id = $(this).data('id');
    $.ajax({
        "url": '{{ URL("vendor_basic_registration/detail_view") }}',
        "data": {"user_id": user_id},
        "type": "POST",
        beforeSend: function(){
            $('#please_wait_loading').show();
        },
        success: function(response){
          $("#LargeModal .modal-content").html(response);
          $("#LargeModal").modal('show');
          // $('#$(".ExtraLargeModal").modal('show');').modal('show');
        },
        complete: function(){
            $("#please_wait_loading").hide();
        }
    });
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

<script>
  $(".custom_close").click(function(){
    $('#myModal').modal('hide');
    $("#LargeModal").modal('show');
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
  $("#approve_button").click(function(){
      approve_reject_delete_vendor('approve');
  });
  $("#reject_button").click(function(){
      approve_reject_delete_vendor('reject');
  });
  $("#delete_button").click(function(){
      approve_reject_delete_vendor('delete');
  });

  
  function approve_reject_delete_vendor(action_flag){
    var favorite = [];
          $.each($("input[name='checkbox']:checked"), function(){
            favorite.push($(this).val());
          });
          var checked_values = favorite.join(",");
          var filter_action = $("#filter_action").val();
  
          if(checked_values.length > 0){
              if (confirm('Are you sure want to '+action_flag+" ?")) {
                    $.ajax({
                      "url": '{{ URL("vendor_basic_registration/approve_reject_delete_action") }}',
                      "data": {"filter_action": filter_action,"checked_values": checked_values,"action_flag": action_flag},
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
          } else {
            alert("Please select anyone.")
          }
  }
  
  </script>

<script>
  $("#filter_action").change(function(){
    $("#approve_button").addClass("disabled");
    $("#reject_button").addClass("disabled");
    $("#delete_button").addClass("disabled");
    var action = $(this).val();
    if(action == "1"){
      $("#approve_button").removeClass("disabled");
      $("#reject_button").removeClass("disabled");
      $("#delete_button").removeClass("disabled");
    } else if(action == "2") {
      $("#delete_button").removeClass("disabled");
    } else if(action == "3") {
      $("#approve_button").removeClass("disabled");
      $("#delete_button").removeClass("disabled");
    }
  });
</script>

@stop {{-- @ JAVASCRIPT SECTION END --}}
