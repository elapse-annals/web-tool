@extends('tools._layout')

@section('title','array compare')

@section('content')
    <form action="" method="post">
        {{ csrf_field() }}
        <textarea name="left" id="" cols="30" rows="20">{{$left}}</textarea>
        <select name="type" id="">
            @if('intersect' == $type)
                <option value="intersect" selected>intersect</option>
            @else
                <option value="intersect">intersect</option>
            @endif
            @if('diff' == $type)
                <option value="diff" selected>diff</option>
            @else
                <option value="diff">diff</option>
            @endif
        </select>
        <textarea name="right" id="" cols="30" rows="20">{{$right}}</textarea>
        <textarea name="result" id="" cols="30" rows="20" disabled>{{$result}}</textarea>
        <input type="reset">
        <input type="submit">
    </form>
@endsection