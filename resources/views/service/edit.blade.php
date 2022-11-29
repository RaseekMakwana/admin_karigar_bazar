@extends('layouts.default.default')

@section('title', 'Update | Service')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-11 mb-0">
          <h4 class="mb-0">Update Service</h4>
        </div>
        <div class="col-sm-1">
            <a href="{{ url('service/manage') }}" class="btn btn-primary btn-block btn-sm">Manage</a>
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

        <form action="{{ url('service/update') }}" method="post" name="serviceForm" id="serviceForm" autocomplete="off">
          @csrf
        
          <hr>
          <div class="row" id="all_block">
                <?php foreach($data['service_data'] as $key => $row){  ?>
                  <div class='col-md-12 single_block' >
                      <div class='row'>
                          <div class='col-md-4'>
                              <div class='form-group'>
                              <input type='text' class='form-control service_name' name='update_service_name[{{ $row->service_id }}]' value="{{ $row->service_name }}" id='service_name' placeholder='service Name'>
                              </div>
                          </div>
                          <div class='col-md-1'>
                              <button type='button' class='btn btn-danger btn-block remove_button' data-serviceid="{{ $row->service_id }}">Remove</button>
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
            <button type="submit" class="btn btn-primary" id="submit_button">Save Service</button>
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
              html += "<input type='text' class='form-control service_name' name='new_service_name[]' id='service_name' placeholder='Service Name'>";
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

  var serviceid = $(this).data('serviceid');
  if(serviceid.length > 0){
    var html = "<input type='hidden' name='removed_service[]' value='"+serviceid+"'>";
    $("#all_removed_block").append(html);
  }
  
})
</script>

<script type="text/javascript">

  $('form[id="serviceForm"]').validate({
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