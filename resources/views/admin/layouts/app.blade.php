<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $settings->meta_keywords }}">
    <meta name="description" content="{{ $settings->meta_description }}">

    <title>{{ $settings->name }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
</head>
<body>
    <div class="loading"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i>جارى التحميل</div>
    <input type="hidden" id="upload-image" value="{{ route('upload.posts.image.all') }}" />
    <div class="app">
        @if ( ! isset ($noNav) )
            @include('admin.layouts.nav')
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if ( isset ( $quill ) )
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('js/tinymce/plugins/images/images.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: 'textarea.tinymce',
                directionality: 'rtl',
                language: 'ar',
                mode: 'textareas',
                plugins: "directionality, lists, link, image,textcolor,images",
                toolbar: 'undo redo | formatselect | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | ltr rtl | numlist bullist outdent indent | link | image | removeformat| images',
                branding: false,
                menubar: false,
                images_upload_url: '{{ route("upload.posts.image") }}',
                relative_urls: false,
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route("upload.posts.image") }}');
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);
                        if(!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
            });
        </script>
    @endif

    <script>
        $(document).ready(function () {
            function forfunc() {
                if ( $('#for').val() == 'category' ){
                    $('#category-group').show();
                    $('#page-group').hide();
                } else if ( $('#for').val() == 'page' ) {
                    $('#category-group').hide();
                    $('#page-group').show();
                }
            }
            forfunc();
            $('#for').on('change', function() {
                forfunc();
            });
           
           checkSliderDate();
           $(".slider-show-label").on("click" , function(){
               hideSliderDate();
           }); 
           function checkSliderDate(){
               if($("#slide").is(":checked")){
                  // show input
                  $(".slider-end-date-container").css("display" , "block");
               }else{
                  // hide input
                  $("#slider-end-date").val("");
                  $(".slider-end-date-container").css("display" , "none");
               }
           }
           function hideSliderDate(){
               if(!$("#slide").is(":checked")){
                  // show input
                  $(".slider-end-date-container").css("display" , "block");
               }else{
                  // hide input
                  $("#slider-end-date").val("");
                  $(".slider-end-date-container").css("display" , "none");
               }
           }
        });
    </script>
</body>
</html>
