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
        </tr>
        </thead>
        <tbody>
        @forelse($rights as $right)
            <tr>
                <td>{{ $right->id }}</td>
                <td>{{ $right->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No rights yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop