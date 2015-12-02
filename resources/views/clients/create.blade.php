@extends('layouts.master')

@section('title', 'Add client')

@section('content')
    <h1>Create new client</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('client.store'))) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
    <a class="button small round secondary" href="{{ route('admin') }}">Cancel</a>
    {!! Form::submit('Create client', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop