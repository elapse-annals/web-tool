@extends('tools._layout')

@section('title','array to string')

@section('content')
    <form action="" method="post">
        {{ csrf_field() }}
        <textarea name="array" id="" cols="30" rows="20">{{$array}}</textarea>
        <input type="text" name="delimiter" value="{{$delimiter}}" width="50px">
        <textarea name="string" id="" cols="30" rows="20" disabled>{{$string}}</textarea>
        <input type="reset">
        <input type="submit">
    </form>
@endsection