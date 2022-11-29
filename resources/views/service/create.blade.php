@extends('layouts.default.default')

@section('title', 'Create | Service')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-11 mb-0">
          <h4 class="mb-0">Create Service</h4>
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

        <form action="{{ url('service/store') }}" method="post" name="serviceForm" id="serviceForm" autocomplete="off">
          @csrf
          <input type="hidden" name="action" value="create">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control select2" name="category" style="width: 100%;" id="category">
                <option value="">-- SELECT --</option>
                <?php foreach($data['category_data'] as $row){ ?>
                  <option value="<?php echo $row->category_id ?>"><?php echo $row->category_name ?></option>
                <?php } ?>
              </select>
              <div id="category_validate"></div>
            </div>
          </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="service_name">Service Add</label>
                <input type="text" class="form-control service_name" name="service_name[]" placeholder="Service Name">
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
  $("#vendor_type").change(function() {
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
            $("#category").html(html);
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
              html += "<input type='text' class='form-control service_name' name='service_name[]' id='service_name' placeholder='Service Name'>";
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

<script>
  $(document).ready(function(){
      $("#submit_button").click(function(){
        
      });
  });
  </script>

<script type="text/javascript">

  $('form[id="serviceForm"]').validate({
      rules: {
        vendor_type: 'required',
        category: 'required',
      },
      messages: {
        vendor_type: 'Vendor Type is required',
        category: 'Category is required',
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