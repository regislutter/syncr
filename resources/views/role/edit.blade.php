@extends('layouts.master')

@section('title', 'Edit role: '.$role->name)

@section('content')
    {!! Form::model($role, array('route' => array('role.update', $role->id), 'method' => 'put')) !!}

    {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}

    <h3>Rights</h3>
    @foreach($rights as $right)
        @if($role->hasRight($right->id))
            <label>	{!! Form::checkbox('rights[]', $right->id,  true, ['id' => 'right'.$right->id]) !!} {{ $right->name }}</label>
        @else
            <label>	{!! Form::checkbox('rights[]', $right->id,  null, ['id' => 'right'.$right->id]) !!} {{ $right->name }}</label>
        @endif
    @endforeach

    <a class="button small round secondary" href="{{ route('role.index') }}">Cancel</a>
    {!! Form::submit('Save role', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}
@stop