@extends('layouts.admin')

@section('title', 'Users list')

@section('content')
    {{--<a class="button small right" href="{{ route('role.index') }}">Manage roles</a>--}}
    <a class="button small round right" href="{{ route('user.create') }}">Create new user</a>
    <h1>Users list</h1>
    <table>
        <thead>
        <tr>
            <th width="60"></th>
            <th>Name</th>
            <th>Email</th>
            @foreach($roles as $role)
                <th>{{ $role->name }}</th>
            @endforeach
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td class="center">
                    <a href="{{ route('user.show', $user->id) }}">
                    @if(isset($user->avatar))
                        <img class="avatar small" src="/images/users/{{ $user->avatar }}" />
                        @else
                        <img data-src="/images/svg/flattened/person-genderless-md.svg" class="iconic iconic-md" alt="person">
                    @endif
                    </a>
                </td>
                <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                @foreach($roles as $role)
                    <td> @if($user->is($role->id)) √ @endif</td>
                @endforeach
                <td>
                    <a href="{{ route('user.edit', $user->id) }}" class="button tiny">Modify</a>
                    <a class="button tiny alert">Delete</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ 4+$roles->count() }}">No users yet?</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {!! $users->render() !!}
@stop