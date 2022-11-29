@extends('layouts.default.default')

@section('title', 'Update | Service')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

<?php 
$vendor_service_data = $data['vendor_service_data'];

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-11 mb-0">
          <h4 class="mb-0">Update Service: <strong><?php echo $vendor_service_data->category_name ?></strong></h4>
        </div>
        <div class="col-sm-1">
            <a href="{{ url('vendor_service/manage/'.$vendor_service_data->user_id) }}" class="btn btn-primary btn-block btn-sm">Manage</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{ url('vendor_service/store') }}" method="post" name="serviceForm" id="serviceForm" autocomplete="off">
    @csrf
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="user_id" value="{{ $vendor_service_data->user_id }}">
    <input type="hidden" name="category_id" value="{{ $vendor_service_data->category_id }}">
      <div class="card card-primary">
          <div class="card-body">
          <?php $ids = explode (",", $vendor_service_data->service_id); ?>
          <div class="form-group">
                  <label for="selected_services" class="col-form-label">Vendor Services</label>
                  <select class="select2" name="selected_services[]" id="selected_services" multiple="multiple" data-placeholder="Select a services" style="width: 100%;">
                      <?php foreach($data['service_data'] as $row){ ?>
                        <option value="<?php echo $row->service_id ?>"  <?php echo (in_array($row->service_id, $ids))? "selected" : "" ?> ><?php echo $row->service_name ?></option>
                      <?php } ?>
                  </select>
              </div>
              
          </div>
          <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm float-right">Save Service</button>
          </div>
      </div>
    </form>
  </section>
  <!-- /.content -->

@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')
<script>
  $("#category").change(function() {
    var category_id = $(this).val();
    $.ajax({
        "url": '{{ URL("cosmatic/get_services_by_category_id") }}',
        "data": {"category_id": category_id},
        "type": "POST",
        beforeSend: function(){
            $('#please_wait_loading').show();
        },
        success: function(response){
            var html = '<option value="">-- SELECT --</option>';
            $.each(response, function(k, val){
                html += '<option value="'+val['service_id']+'">'+val['service_name']+'</option>';
            });
            $("#selected_services").html(html);
        },
        complete: function(){
            $("#please_wait_loading").hide();
        }
    });
  });
</script>


<script type="text/javascript">

  $('form[id="areaForm"]').validate({
      rules: {
        city: 'required',
        state: 'required',
      },
      messages: {
        city: 'City is required',
        state: 'State is required',
      },
      errorPlacement: function (error, element) {
        var name    = $(element).attr("id");
        var $obj    = $("#" + name + "_validate");
        error.appendTo($obj);
      },
      submitHandler: function(form) {
        form.submit();
      }
  });
</script>

@stop {{-- @ JAVASCRIPT SECTION END --}}