@extends('layouts.default.default')

@section('title', 'Create | Vandor')

@section('page_style')
@stop {{-- @ STYLE SECTION END --}}

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-11 mb-0">
                    <h4 class="mb-0">Language Converter</h4>
                </div>
                <div class="col-sm-1">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor_name">Write text here</label>
                                <input type="text" class="form-control" name="input_text" id="input_text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="margin-top: 31px">
                                <button type="submit" class="btn btn-primary" id="conver_button">Convert</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Language Converter</h3>
                                </div>
    
                                <div class="card-body p-0">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>Language</th>
                                                <th>Code</th>
                                                <th>Convert Value</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body_html">
    
                                        </tbody>
                                    </table>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')
    <script>
        $("#conver_button").click(function() {
            var input_text = $("#input_text").val();
            if (input_text) {
                $.ajax({
                    "url": "{{ URL('language-converter/convert') }}",
                    "data": {
                        "input_text": input_text
                    },
                    "type": "POST",
                    beforeSend: function() {
                        $('#please_wait_loading').show();
                    },
                    success: function(response) {
                        var html = "";
                        $.each(response, function(key, value) {
                            html += '<tr>';
                                html += '<td>' + value.language_name + '</td>';
                                html += '<td>' + value.language_code + '</td>';
                                html += '<td>' + value.convert_value + '</td>';
                                html += '<td><input type="text" id="language_box_'+key+'" value="' + value.convert_value + '" style="width: 0px; height: 0px; visibility: hidden"><a href="javascript:void(0)" onclick="copyToClipboard('+key+')"><i class="fa fa-copy" aria-hidden="true"></i> Copy</a></td>';
                            html += '</tr>';
                        });
                        $('#table_body_html').html(html);
                    },
                    complete: function() {
                        $("#please_wait_loading").hide();
                    }
                });
            }
        });
    </script>


<script>
    function copyToClipboard(key) {
    var copyText = document.getElementById("language_box_"+key).value;
    navigator.clipboard.writeText(copyText).then(() => {
        // alert("Copied to clipboard");
    });
  }
</script>
@stop {{-- @ JAVASCRIPT SECTION END --}}
