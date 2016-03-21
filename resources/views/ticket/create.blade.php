@extends('layouts.master')

@section('title', 'Create new ticket')

@section('content')
    <h1>Create new ticket</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('ticket.store'))) !!}

    <div class="row">
        <div class="large-12 columns">
    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
    {!! Form::label('description', 'Description') !!}{!! Form::textarea('description') !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            {!! Form::label('project_id', 'Project') !!}{!! Form::select('project_id', $projects) !!}
        </div>
        <div class="large-6 medium-6 columns">
            {!! Form::label('category', 'Category') !!}{!! Form::select('category', $categories, 2) !!}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            {!! Form::label('user_id', 'User') !!}{!! Form::select('user_id', $users) !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
    {!! Form::label('priority', 'Priority') !!}{!! Form::select('priority', $priorities, 1) !!}
        </div>
        <div class="large-6 medium-6 columns">
    {!! Form::label('estimate', 'Estimate') !!}{!! Form::select('estimate', $estimates, 2) !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
    {!! Form::label('date_start', 'Date start') !!}{!! Form::input('date', 'date_start') !!}
        </div>
        <div class="large-6 medium-6 columns">
    {!! Form::label('date_end', 'Deadline') !!}{!! Form::input('date', 'date_end') !!}
        </div>
    </div>
    <a class="button small round secondary" href="{{ route('ticket.index') }}">Cancel</a>
    {!! Form::submit('Create ticket', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop