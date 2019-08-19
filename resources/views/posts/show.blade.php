@extends('layout.app')
 
@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a><br>
    <img style="width:50%" src="/storage/cover_images/{{$post->cover_image}}">
    <h1>Title : {{$post->title}}</h1>
    <div>Body : {!!$post->body!!}</div>
    <hr>
    <small>Written on : {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <table>
                <tr>
                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                    <td>
                        {!!Form::open(['action'=> ['PostsController@destroy', $post->id], 'method'=>'POST', 'class'=> 'pull-right'])!!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                        {!!Form::close()!!}
                    </td>
                </tr>
            </table>
        @endif
    @endif    
@endsection