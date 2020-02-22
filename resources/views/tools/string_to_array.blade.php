@extends('tools._layout')

@section('content')
    <form action="" method="post">
        {{ csrf_field() }}
        <textarea name="string" id="" cols="30" rows="20">{{$string}}</textarea>
        <input type="text" name="delimiter" value="{{$delimiter}}" width="50px">
        <textarea name="array" id="" cols="30" rows="20" disabled>{{$array}}</textarea>
        <input type="reset">
        <input type="submit">
    </form>
@endsection