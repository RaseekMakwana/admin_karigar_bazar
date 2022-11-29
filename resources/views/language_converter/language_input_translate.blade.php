@extends('layouts.default.default')

@section('title', 'Create | Vandor')

@section('page_style')
        <script type="text/javascript" src="{{ asset('plugins/g_keyboard/main_transliteration.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/g_keyboard/transliteration.I.js') }}"></script>
		<link type="text/css" href="{{ asset('plugins/g_keyboard/transliteration.css') }}" rel="stylesheet"/>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
@stop {{-- @ STYLE SECTION END --}}

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-11 mb-0">
                    <h4 class="mb-0">Input Converter</h4>
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
                <div class="card-header">
                    <h3 class="card-title">Language Converter</h3>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <select name="languages" id="languageDropDown" onchange="javascript:languageChangeHandler()" class="form-control">
                            <option value="en">English</option>
                            <option value="hi">Hindi</option>
                            <option value="gu">Gujarati</option>
                            <option value="mr">Marathi</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <textarea cols="50" rows="5" class="form-control" name="editor1" id="msg_editor" placeholder="Write here ..."></textarea>				
                    </div>
                    
                </div>
            </div>
        </div>
        
    </section>

@stop {{-- @ CONTENT SECTION END --}}

@section('page_javascript')


<script>
    function copyToClipboard(key) {
    var copyText = document.getElementById("language_box_"+key).value;
    navigator.clipboard.writeText(copyText).then(() => {
        // alert("Copied to clipboard");
    });
  }
</script>

<script type="text/javascript">
    //<![CDATA[
    // var Translator = new Translate([]);
    //]]>
    google.load("elements", "1", {
        packages: "transliteration"
    });
    var control;
    function onLoad() {
        var options = {
            sourceLanguage:
                    google.elements.transliteration.LanguageCode.ENGLISH,
            destinationLanguage:
                    ['hi','gu', 'mr'],
            shortcutKey: 'ctrl+g',
            transliterationEnabled: false
        };
        control =
                new google.elements.transliteration.TransliterationControl(options);
        control.makeTransliteratable(['msg_editor']);
    }
    function languageChangeHandler() {
        var dropdown = document.getElementById('languageDropDown');
        if(dropdown.options[dropdown.selectedIndex].value == 'en'){
            control.disableTransliteration();
        }else{
            control.enableTransliteration();
            
        control.setLanguagePair(
                google.elements.transliteration.LanguageCode.ENGLISH,
                dropdown.options[dropdown.selectedIndex].value);
            }
    }
    google.setOnLoadCallback(onLoad);

    function needtranslator(){
        jQuery("#editortypewriter").css('display', 'block');
    }

    function closeeditor() {
        jQuery("#editortypewriter").css('display', 'none');
    }
</script>
@stop {{-- @ JAVASCRIPT SECTION END --}}
