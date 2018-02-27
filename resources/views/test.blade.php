<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
          integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <script src="https://widget.cloudinary.com/global/all.js"></script>
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>

    <style>

    </style>
</head>
<body>
<!-- Begin page content -->
<form id="upload" name="upload" method="post" action="{{ route('test_upload') }}" enctype="multipart/form-data">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <div class="form-group">

        <input class="inputfile" id="files" accept="image/*" type="file" name="file[]" required>
        <label class="btn btn-primary mb-2" for="files">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
            </svg>
            <span class="upload_text">Выберите фото</span></label>
    </div>
    <button class="btn btn-primary mb-2" type="submit">Загрузить</button>
</form>
</body>
</html>