<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ csrf_field() }}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/test" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">File</label>
        <input type="file" name="file" id="file">
        <input type="submit" value="Submit">
    </form>
    @isset($match)
        <iframe src="https://docs.google.com/presentation/d/{{ $match['id'] }}/preview" frameborder="0" style="width: 100vw; height: 100vh;"></iframe>
    @endisset
</body>
</html>