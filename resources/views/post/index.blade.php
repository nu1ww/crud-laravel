@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @foreach($posts as $row)
                    <h2>{{$row->title}}</h2>
                    <h5>{{$row->body}}</h5>
                <a href="{{url('posts')}}/{{$row->id}}">Edit</a>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection
