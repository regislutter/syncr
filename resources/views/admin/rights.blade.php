@extends('layouts.admin')

@section('title', 'Rights list')

@section('content')
    <a class="button small round right" href="{{ route('right.create') }}">Create new right</a>
    <h1>Rights list</h1>
    <table>
        <thead>
        <tr>
            <th width="100">ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($rights as $right)
            <tr>
                <td>{{ $right->id }}</td>
                <td>{{ $right->name }}</td>
                <td>
                    <a href="{{ route('right.edit', $right->id) }}" class="button tiny">Modify</a>
                    {!! Form::open(array('route' => array('right.destroy', $right->id), 'method' => 'delete')) !!}
                    <button type="submit" class="button tiny alert">Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No rights yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop