@extends('layouts.admin')

@section('title', 'Roles list')

@section('content')
    <a class="button small round right" href="{{ route('role.create') }}">Create new role</a>
    <h1>Roles list</h1>
    <table>
        <thead>
        <tr>
            <th width="100">ID</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        @forelse($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No roles yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop