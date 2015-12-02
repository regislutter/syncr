@extends('layouts.master')

@section('title', 'Edit client '.$client->name)

@section('content')
    <h1>Edit client: {{ $client->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($client, array('url' => route('client.update', $client->id), 'method' => 'put')) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    <a class="button small round secondary" href="{{ route('client.show', $client->id) }}">Cancel</a>
    {!! Form::submit('Edit client', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop