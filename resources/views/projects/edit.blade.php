@extends('layouts.master')

@section('title', 'Edit project '.$project->name)

@section('content')
    <h1>Edit project: {{ $project->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($project, array('url' => route('project.update', $project->id), 'method' => 'put')) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    {!! Form::label('client', 'Client') !!}{!! Form::select('client', $clientsList, $project->client->id) !!}
    <a class="button tiny" href="{{ route('client.create') }}">Create new client</a><br/><br/>
    <a class="button small round secondary" href="{{ route('project.show', $project->id) }}">Cancel</a>
    {!! Form::submit('Edit project', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop