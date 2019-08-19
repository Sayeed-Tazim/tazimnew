@extends('layout.app')
 
@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>create post</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST' , 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('tilte','Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' =>'Title'])}}            
        </div>
        <div class="form-group">
                {{Form::label('body','Body')}}
                {{Form::textarea('body', '', ['id'=>'article-ckeditor','class' => 'form-control', 'placeholder' =>'Body Text Here'])}}           
        </div> 
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit', ['class' =>'btn btn-primary'])}}
    {!!Form::close()!!}
@endsection