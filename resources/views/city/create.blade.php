@extends('layouts.default.default')

@section('title', 'Create | City')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-11 mb-0">
          <h4 class="mb-0">Create City</h4>
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
          <input type="hidden" name="action" value="create">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="state">State</label>
              <select class="form-control" name="state" style="width: 100%;" id="state">
                <option value="">-- SELECT --</option>
                <?php foreach($data['state_data'] as $row){ ?>
                  <option value="<?php echo $row->state_id ?>"><?php echo $row->state_name ?></option>
                <?php } ?>
              </select>
              <div id="state_validate"></div>
            </div>
          </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="city_name">City Add</label>
                <input type="text" class="form-control city_name" name="city_name[]" placeholder="City Name">
              </div>
            </div>
          </div>
          <div class="row" id="all_block">
          </div>
          <div class="row">
            <div class="col-md-1">
              <button type="button" class="btn btn-success btn-block" id="add_button">Add Row</button>
            </div>
          </div>
          <div class="row">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary" id="submit_button">Save City</button>
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

<script>
$(document).ready(function(){
  $("#add_button").click(function(){
    var html = "<div class='col-md-12 single_block'>";
      html += "<div class='row'>";
          html += "<div class='col-md-4'>";
              html += "<div class='form-group'>";
              html += "<input type='text' class='form-control city_name' name='city_name[]' id='city_name' placeholder='City Name'>";
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
})
</script>

@stop {{-- @ JAVASCRIPT SECTION END --}}