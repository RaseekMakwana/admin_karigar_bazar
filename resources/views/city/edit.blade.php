@extends('layouts.default.default')

@section('title', 'Update | City')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-11 mb-0">
          <h4 class="mb-0">Update City</h4>
        </div>
        <div class="col-sm-1">
            <a href="{{ url('city/manage') }}" class="btn btn-primary btn-block btn-sm">Manage</a>
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

        <form action="{{ url('city/store') }}" method="post" name="cityForm" id="cityForm" autocomplete="off">
          @csrf
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="city_id" value="<?php echo $data['edit_details']->city_id; ?>">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="state">State</label>
              <select class="form-control" name="state" style="width: 100%;" id="state">
                <option value="">-- SELECT --</option>
                <?php foreach($data['state_data'] as $row){ ?>
                  <option value="<?php echo $row->state_id ?>" <?php echo ($row->state_id == $data['edit_details']->state_id)? "selected" : "" ; ?>><?php echo $row->state_name ?></option>
                <?php } ?>
              </select>
              <div id="state_validate"></div>
            </div>
          </div>
          </div>
          <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="city_name">City Name</label>
              <input type="text" class="form-control" name="city_name" id="city_name" value="<?php echo $data['edit_details']->city_name; ?>">
              <div id="city_name_validate"></div>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Update</button>
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
  $("#mobile_number").keyup(function(){
    $("#mobile_exist_validate").hide();
  });
</script>

<script>
  $("#state").change(function() {
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
            $("#city").html(html);
        },
        complete: function(){
            $("#please_wait_loading").hide();
        }
    });
  });
</script>


<script type="text/javascript">

  $('form[id="cityForm"]').validate({
      rules: {
        city_name: 'required',
        state: 'required',
      },
      messages: {
        city_name: 'City is required',
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