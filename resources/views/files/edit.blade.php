@extends('layouts.master')

@section('title', 'Edit copydeck version')

@section('content')
    <h1>Edit version {{ $file->version }} for {{ $copydeck->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($file, array('url' => route('file.update', [$file->id]), 'method' => 'put')) !!}

    @if(empty($file->link))
        {!! Form::label('tinycontent', 'Online content:') !!} {!! Form::textarea('tinycontent', $file->content) !!}<br/>
    @else
        <a href="#" class="findPath label round right">Where to find the server path ?</a>
        {!! Form::label('link', 'Server path:') !!} {!! Form::text('link') !!}<br/>
    @endif

    <div class="row">
        <div class="large-12 columns">
            <a class="button small round secondary" href="{{ route('copydeck.show', $copydeck->id) }}">Cancel</a>
            {!! Form::submit('Save copydeck version', array('class' => 'button small round success')) !!}
        </div>
    </div>


    {!! Form::close() !!}
@stop

@section('javascript')
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#tinycontent'
        });
    </script>
@stop