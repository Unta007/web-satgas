tinymce.init({
    selector: 'textarea#article-description',
    plugins: 'code table lists image media link',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist | code | table | image media link',

    images_upload_url: '{{ route("admin.articles.upload_image") }}',
    images_upload_credentials: true,
    file_picker_types: 'image',
    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route("admin.articles.upload_image") }}');

        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status < 200 || xhr.status >= 300) {
                return reject('HTTP Error: ' + xhr.status);
            }

            const json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                return reject('Invalid JSON: ' + xhr.responseText);
            }

            resolve(json.location);
        };

        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    })
});
