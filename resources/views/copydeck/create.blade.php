@extends('layouts.master')

@section('title', 'Create new document')

@section('content')
    <h1>Create new document in {{ $project->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('copydeck.store', $project->id))) !!}

    {!! Form::label('name', 'Name:') !!} {!! Form::text('name') !!}<br/>
    <a href="#" class="findPath label round right">Where to find the server path ?</a>
    {!! Form::label('link', 'Server path:') !!} {!! Form::text('link') !!}<br/>

    {!! Form::label('tinycontent', 'Online content:') !!} {!! Form::textarea('tinycontent') !!}<br/>

    <div class="row collapse">
        <div class="large-1 columns">
            <label for="version">Version:</label>
        </div>
        <div class="large-5 columns">
            <div class="row collapse postfix-radius">
                <div class="small-2 columns">
                    {!! Form::input('number', 'version1', 1, ['id' => 'version1']) !!}
                </div>
                <div class="small-1 columns">
                    <span class="postfix">.0</span>
                </div>
                <div class="small-2 columns">
                    {!! Form::input('number', 'version2', 0, ['id' => 'version2']) !!}
                </div>
                <div class="small-7 columns">
                </div>
            </div>
        </div>
        <div class="large-6 columns">
        </div>
    </div><br/><br/>

    <a class="button small round secondary" href="{{ route('project.show', $project->id) }}">Cancel</a>
    {!! Form::submit('Create copydeck', ['class' => 'button small round success']) !!}

    {!! Form::close() !!}
@stop

@section('javascript)
    <script>
        tinymce.init({
            selector: '#tinycontent'
        });
    </script>
@stop