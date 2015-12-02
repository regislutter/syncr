@extends('layouts.admin')

@section('title', 'Admin Clients')

@section('content')
    <?php $archived = $clients->filter(function ($item) { return $item->archived == 1; });
    $active = $clients->filter(function ($item) { return $item->archived == 0; }); ?>
    <a class="button small round right" href="{{ route('client.create') }}"><span class="fi-plus" title="plus" aria-hidden="true"></span> Create new client</a>
    <h4>{{ $active->count() }} Active clients</h4>
    <table>
        <thead>
        <tr>
            <th>Client</th>
            <th width="100" class="center">Projects</th>
            <th width="250">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($active as $client)
            <tr>
                <td><a href="{{ route('client.show', [$client->id]) }}">{{ $client->name }}</a></td>
                <td class="center">{{ $client->projects->count() }}</td>
                <td>
                    @if(\Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a class="button tiny warning" href="{{ route('client.archive', $client->id) }}"><span class="fi-folder" title="archive" aria-hidden="true"></span> Archive</a>
                    @endif
                    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a href="{{ route('client.edit', $client->id) }}" class="button tiny"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Modify</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h4>{{ $archived->count() }} Archived clients</h4>
    <table>
        <thead>
        <tr>
            <th>Client</th>
            <th width="100" class="center">Projects</th>
            <th width="250">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($archived as $client)
            <tr>
                <td><a href="{{ route('client.show', [$client->id]) }}">{{ $client->name }}</a></td>
                <td class="center">{{ $client->projects->count() }}</td>
                <td>
                    @if(\Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a class="button tiny success" href="{{ route('client.publish', $client->id) }}"><span class="fi-history" title="republish" aria-hidden="true"></span> Republish</a>
                    @endif
                    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a href="{{ route('client.edit', $client->id) }}" class="button tiny"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Modify</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop