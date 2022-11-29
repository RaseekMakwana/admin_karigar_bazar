@extends('layouts.default.default')

@section('title', 'Update | Category')

@section('page_style')

@stop {{-- @ STYLE SECTION END --}}

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-11 mb-0">
                    <h4 class="mb-0">Update Category</h4>
                </div>
                <div class="col-sm-1">
                    <a href="{{ url('category/manage') }}" class="btn btn-primary btn-block btn-sm">Manage</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">

                @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                    </div>
                @endif

                <form action="{{ url('category/update') }}" method="post" name="categoryForm" id="categoryForm"
                    autocomplete="off">
                    @csrf
                    <div class="row" id="all_block">
                        <?php foreach($data['category_data'] as $key => $row){  ?>
                        <div class='col-md-12 single_block'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <input type='text' class='form-control category_name'
                                            name='update_category_name[{{ $row->category_id }}]'
                                            value="{{ $row->category_name }}" id='category_name'
                                            placeholder='category Name'>
                                    </div>
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
                            <button type="submit" class="btn btn-primary" id="submit_button">Save category</button>
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
        $(document).ready(function() {
            $("#add_button").click(function() {
                var html = "<div class='col-md-12 single_block'>";
                html += "<div class='row'>";
                html += "<div class='col-md-4'>";
                html += "<div class='form-group'>";
                html +=
                    "<input type='text' class='form-control category_name' name='new_category_name[]' id='category_name' placeholder='category Name'>";
                html += "</div>";
                html += "</div>";
                html += "<div class='col-md-1'>";
                html +=
                    "<button type='button' class='btn btn-danger btn-block remove_button'>Remove</button>";
                html += "</div>";
                html += "</div>";
                html += "</div>";
                $("#all_block").append(html);
            });


        });

        $(document).on("click", ".remove_button", function() {
            $(this).closest(".single_block").remove();

            var categoryid = $(this).data('categoryid');
            if (categoryid.length > 0) {
                var html = "<input type='hidden' name='removed_category[]' value='" + categoryid + "'>";
                $("#all_removed_block").append(html);
            }

        })
    </script>

    <script type="text/javascript">
        $('form[id="categoryForm"]').validate({
            rules: {
                city: 'required',
                state: 'required',
            },
            messages: {
                city: 'City is required',
                state: 'State is required',
            },
            errorPlacement: function(error, element) {
                var name = $(element).attr("id");
                var $obj = $("#" + name + "_validate");
                error.appendTo($obj);
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>

@stop {{-- @ JAVASCRIPT SECTION END --}}
