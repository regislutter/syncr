@extends('layouts.master')

@section('title', 'New message in discussion')

@section('content')
    <h1>New message in discussion: {{ $discussion->title }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('discussion.message.create', [$discussion->id]))) !!}

    {!! Form::label('tinycontent', 'Message:') !!} {!! Form::textarea('tinycontent') !!}<br/>

    <a class="button small round secondary" href="{{ route('discussion.show', $discussion->id) }}">Cancel</a>
    {!! Form::submit('Send new message', ['class' => 'button small round success']) !!}

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