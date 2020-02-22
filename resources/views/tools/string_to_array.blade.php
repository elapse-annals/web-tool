<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('tools._head')
    <title>string to array</title>
</head>
<body>
<form action="" method="post">
    {{ csrf_field() }}
    <textarea name="string" id="" cols="30" rows="20">{{$string}}</textarea>
    <input type="text" name="delimiter" value="{{$delimiter}}" width="50px">
    <textarea name="array" id="" cols="30" rows="20" disabled>{{$array}}</textarea>
    <input type="reset">
    <input type="submit">
</form>
</body>
</html>