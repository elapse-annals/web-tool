@extends('tools._layout')

@section('title','array unique')

@section('content')
    <form action="" method="post">
        {{ csrf_field() }}
        <label for="array">to be repeated</label>
        <textarea name="array" id="array" cols="30" rows="20">{{$array}}</textarea>
        <label for="result">result</label>
        <textarea name="result" id="result" cols="30" rows="20" disabled>{{$result}}</textarea>
        <input type="reset">
        <input type="submit">
    </form>
@endsection