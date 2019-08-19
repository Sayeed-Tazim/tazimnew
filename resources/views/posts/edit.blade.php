@extends('layout.app')
 
@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>edit post</h1>
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST','enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('tilte','Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' =>'Title'])}}            
        </div>
        <div class="form-group">
                {{Form::label('body','Body')}}
                {{Form::textarea('body', $post->body, ['id'=>'article-ckeditor','class' => 'form-control', 'placeholder' =>'Body Text Here'])}}           
        </div> 
        <div class="form-group">
                {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Done', ['class' =>'btn btn-primary'])}}
    {!!Form::close()!!}
@endsection