@extends('layouts.master')

@section('title', 'Edit Document')

@section('content')
    <h1>Edit document: {{ $copydeck->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($copydeck, array('url' => route('copydeck.update', $copydeck->id), 'method' => 'put')) !!}

    {!! Form::label('name', 'Name:') !!} {!! Form::text('name') !!}<br/>
    <a class="button small round secondary" href="{{ route('copydeck.show', $copydeck->id) }}">Cancel</a>
    {!! Form::submit('Edit copydeck', ['class' => 'button small round success']) !!}

    {!! Form::close() !!}
@stop