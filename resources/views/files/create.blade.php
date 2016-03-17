@extends('layouts.master')

@section('title', 'New copydeck version')

@section('content')
    <h1>Create a new version for {{ $copydeck->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('file.create', [$copydeck->project_id, $copydeck->id]))) !!}

    <a href="#" class="findPath label round right">Where to find the server path ?</a>
    {!! Form::label('link', 'Server path:') !!} {!! Form::text('link') !!}<br/>

    {!! Form::label('tinycontent', 'Online content:') !!} {!! Form::textarea('tinycontent') !!}<br/>

    <?php $lastVersion = $copydeck->files->last()->version;
    $pointPos = strpos($lastVersion, '.');
    $v1 = substr($lastVersion, 0, $pointPos);
    $v2 = substr($lastVersion, $pointPos+1);
    ?>

    <div class="row collapse">
        <div class="large-1 columns">
            <label for="version">Version:</label>
        </div>
        <div class="large-5 columns">
            <div class="row collapse postfix-radius">
                <div class="small-2 columns">
                    {!! Form::input('number', 'version1', $v1, ['id' => 'version1']) !!}
                </div>
                <div class="small-1 columns">
                    <span class="postfix">.0</span>
                </div>
                <div class="small-2 columns">
                    {!! Form::input('number', 'version2', $v2+1, ['id' => 'version2']) !!}
                </div>
                <div class="small-1 columns">
                </div>
                <div class="small-6 columns">
                    <a class="round label changeFileVersion" data-version1="{{ $v1+1 }}" data-version2="0" href="#">Major version</a>
                    <a class="round label changeFileVersion" data-version1="{{ $v1 }}" data-version2="{{ $v2+1 }}" href="#">Minor version</a>
                </div>
            </div>
        </div>
        <div class="large-6 columns">
            Last version: {{ $lastVersion }}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <a class="button small round secondary" href="{{ route('copydeck.show', $copydeck->id) }}">Cancel</a>
            {!! Form::submit('Create new version', array('class' => 'button small round success')) !!}
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