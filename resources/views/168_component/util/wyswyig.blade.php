
@push("css")
    <link rel="stylesheet" href="{{ asset('/168_res') }}/vendor/summernote/summernote-lite.min.css">
@endpush


@push("script")

<script src="{{ asset('/168_res') }}/vendor/summernote/summernote-lite.min.js"></script>
<script>

    $('#summernote').summernote({
        tabsize: 2,
        height: 120,
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

        var hoste = "http://127.0.0.1:26100/summernote-image";
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

    function progressHandlingFunction(e) {

    }
</script>
@endpush