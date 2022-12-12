
@push("css")
    <link rel="stylesheet" href="{{ asset('/168_res') }}/vendor/summernote/summernote-lite.min.css">
@endpush


@push("script")

<script src="{{ asset('/168_res') }}/vendor/summernote/summernote-lite.min.js"></script>
<script>

    var hoste = "http://127.0.0.1:148/summernote-image";

    $('#summernote').summernote({
        tabsize: 2,
        height: 300,
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            },
            onMediaDelete: function (target) {
                alert(target[0].src)
                alert("On Media Delete")
                deleteFile(target[0].src);
            }
        }
    })
    $('#summernote2').summernote({
        tabsize: 2,
        height: 120,
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                sendFile2(files[0], editor, welEditable);
            },
            onMediaDelete: function (target) {
                alert(target[0].src)
                alert("On Media Delete")
                deleteFile(target[0].src);
            }
        }
    })

    $('#summernote3').summernote({
        tabsize: 2,
        height: 120,
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                sendFile3(files[0], editor, welEditable);
            },
            onMediaDelete: function (target) {
                alert(target[0].src)
                alert("On Media Delete")
                deleteFile(target[0].src);
            }
        }
    })

    function deleteFile(src) {
        var host = window.location.origin;
        $.ajax({
            data: {
                "_token": "{{ csrf_token() }}",
                src: src
            },
            type: "POST",
            url: host + "/summernote-image-delete", // replace with your url
            cache: false,
            success: function (resp) {
                console.log(resp);
                console.log("Success Delete Image")
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let error = (textStatus + " " + errorThrown);
                console.log(error)
                alert(error + jqXHR.responseText)
            }
        });
    }

    function sendFile(file, editor, welEditable) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: 'POST',
            url: hoste,
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                alert(url)
                var image = $('<img>').attr('src', url);
                $('#summernote').summernote('insertImage', url, url);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let error = (textStatus + " " + errorThrown);
                console.log(error)
                alert(error + jqXHR.responseText)
            }
        });
    }

    function sendFile2(file, editor, welEditable) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: 'POST',
            url: hoste,
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                alert(url)
                var image = $('<img>').attr('src', url);
                $('#summernote2').summernote('insertImage', url, url);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let error = (textStatus + " " + errorThrown);
                console.log(error)
                alert(error + jqXHR.responseText)
            }
        });
    }

    function sendFile3(file, editor, welEditable) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: 'POST',
            url: hoste,
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                alert(url)
                var image = $('<img>').attr('src', url);
                $('#summernote3').summernote('insertImage', url, url);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let error = (textStatus + " " + errorThrown);
                console.log(error)
                alert(error + jqXHR.responseText)
            }
        });
    }

    function progressHandlingFunction(e) {

    }
</script>
@endpush
