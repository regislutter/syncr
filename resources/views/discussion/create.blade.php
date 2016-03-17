@extends('layouts.master')

@section('title', 'Open new discussion')

@section('content')
    <?php
        $title = 'New discussion in ';
        $formRoute = 'project.discussion.create';
        $formParams = [$project->id];
        if(isset($copydeck)){
            $title .= 'copydeck: '.$copydeck->name;
            $formRoute = 'copydeck.discussion.create';
            array_push($formParams, $copydeck->id);
        } else {
            $title .= 'project: '.$project->name;
        }
    ?>
    <h1>{{ $title }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route($formRoute, $formParams))) !!}

    {!! Form::label('title', 'Title:') !!} {!! Form::text('title') !!}<br/>

    {!! Form::label('tinycontent', 'Message:') !!} {!! Form::textarea('tinycontent') !!}<br/>

    @if(isset($copydeck))
        <a class="button small round secondary" href="{{ route('copydeck.show', $copydeck->id) }}">Cancel</a>
    @else
        <a class="button small round secondary" href="{{ route('project.show', $project->id) }}">Cancel</a>
    @endif
    {!! Form::submit('Open discussion', ['class' => 'button small round success']) !!}

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