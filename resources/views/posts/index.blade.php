@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <a href="/home" class="btn btn-primary">Back</a> 
        </div>
        <div class="col-md-4" float="right">
            {{-- <form action="{{ route/('search')}}" method="GET">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Search Here">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>  --}}
            {{-- <form method="POST" action='{{url("/search")}}'>
                <div class="input-group">
                    <input type="search" name="search" placeholder="Search Here" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>            --}}
        </div>
    </div>
    <h1>Posts</h1>       
    @if(count($posts)>0)
        @foreach ($posts as $post)
            <div class="well">
                <div class="row">
                        <div class="col-md-4 col-sm-4">
                                <img style="width:50%" src="/storage/cover_images/{{$post->cover_image}}">
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                            {{-- <h6>{!!$post->body!!}</h6> --}}
                            <small>posts created at {{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                </div>
                <br> 
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No Posts found</p>
    @endif
@endsection   