@extends('layouts.default.default')

@section('title', 'Update | Area')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-11 mb-0">
          <h4 class="mb-0">Update Area</h4>
        </div>
        <div class="col-sm-1">
            <a href="{{ url('area/manage') }}" class="btn btn-primary btn-block btn-sm">Manage</a>
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

        <form action="{{ url('area/store') }}" method="post" name="areaForm" id="areaForm" autocomplete="off">
          @csrf
          <input type="hidden" name="action" value="edit">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="state">State</label>
              <select class="form-control" name="state" style="width: 100%;" id="state">
                <option value="">-- SELECT --</option>
                <?php foreach($data['state_data'] as $row){ ?>
                  <option value="<?php echo $row->state_id ?>" <?php echo ($row->state_id == $data['selected_state'])? "selected" : "" ; ?>><?php echo $row->state_name ?></option>
                <?php } ?>
              </select>
              <div id="state_validate"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="area">City</label>
              <select class="form-control" name="city" style="width: 100%;" id="city">
                <option value="">-- SELECT --</option>
                <?php foreach($data['city_data'] as $row){ ?>
                  <option value="<?php echo $row->city_id ?>" <?php echo ($row->city_id == $data['selected_city'])? "selected" : "" ; ?>><?php echo $row->city_name ?></option>
                <?php } ?>
              </select>
              <div id="city_validate"></div>
            </div>
          </div>
          </div>
          <hr>
          <div class="row" id="all_block">
                <?php foreach($data['area_data'] as $key => $row){  ?>
                  <div class='col-md-12 single_block' >
                      <div class='row'>
                          <div class='col-md-4'>
                              <div class='form-group'>
                              <input type='text' class='form-control area_name' name='update_area_name[{{ $row->area_id }}][]' value="{{ $row->area_name }}" id='area_name' placeholder='Area Name'>
                              </div>
                          </div>
                          <div class='col-md-1'>
                              <button type='button' class='btn btn-danger btn-block remove_button' data-areaid="{{ $row->area_id }}">Remove</button>
                          </div>
                      </div>
                    </div>
                <?php } ?>
          </div>
          <div class="row" id="all_removed_block">
                
          </div>
          <div class="row">
            <div class="col-md-1">
              <button type="button" class="btn btn-success btn-block" id="add_button">Add Row</button>
            </div>
          </div>
          <div class="row">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary" id="submit_button">Save Area</button>
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

<script>
$(document).ready(function(){
  $("#add_button").click(function(){
    var html = "<div class='col-md-12 single_block'>";
      html += "<div class='row'>";
          html += "<div class='col-md-4'>";
              html += "<div class='form-group'>";
              html += "<input type='text' class='form-control area_name' name='new_area_name[]' id='area_name' placeholder='Area Name'>";
              html += "</div>";
          html += "</div>";
          html += "<div class='col-md-1'>";
              html += "<button type='button' class='btn btn-danger btn-block remove_button'>Remove</button>";
          html += "</div>";
      html += "</div>";
    html += "</div>";
    $("#all_block").append(html);
  });


});

$(document).on("click",".remove_button",function(){
  $(this).closest(".single_block").remove();

  var areaid = $(this).data('areaid');
  if(areaid.length > 0){
    var html = "<input type='hidden' name='removed_area[]' value='"+areaid+"'>";
    $("#all_removed_block").append(html);
  }
  
})
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