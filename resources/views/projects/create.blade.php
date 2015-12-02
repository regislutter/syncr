@extends('layouts.master')

@section('title', 'Create project')

@section('content')
    <h1>Create new project</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('project.store'))) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    {!! Form::label('client', 'Client') !!}{!! Form::select('client', $clientsList, $clientId) !!}
    <a class="button tiny" href="{{ route('client.create') }}">Create new client</a><br/><br/>
    <a class="button small round secondary" href="{{ route('home') }}">Cancel</a>
    {!! Form::submit('Create project', ['class' => 'button small round success']) !!}

    {!! Form::close() !!}
@stop