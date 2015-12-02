@extends('layouts.master')

@section('title', 'Client ' . $client->name)

@section('content')
    <?php $archived = $client->projects->filter(function ($item) { return $item->archived == 1; });
    $active = $client->projects->filter(function ($item) { return $item->archived == 0; }); ?>
    <h1>{{ $client->name }}</h1>
    <a class="button small round right" href="{{ route('project.create', ['client' => $client->id]) }}"><span class="fi-plus" title="plus" aria-hidden="true"></span> Create new project</a>
    <h4>{{ $active->count() }} Active projects</h4>
    <table>
        <thead>
        <tr>
            <th width="50" class="center"></th>
            <th width="200">Project</th>
            <th width="100" class="center">Copydecks</th>
            <th>Last copydeck</th>
            <th width="250">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($active as $project)
            <tr>
                <?php $sub = \Auth::user()->subscriptions->where('project_id', $project->id); ?>
                <td class="center">
                    @if($sub->count() > 0)
                        <span class="fi-eye-open success" title="subscribed" aria-hidden="true"></span>
                    @else
                        <span class="fi-eye-closed warning" title="not subscribed" aria-hidden="true"></span>
                    @endif</td>
                <td><a href="{{ route('project.show', [$project->id]) }}">{{ $project->name }}</a></td>
                <?php $nbCd = $project->copydecks->count(); ?>
                <td class="center">{{ $nbCd }}</td>
                <td>@if($nbCd) <a href="{{ route('copydeck.show', $project->copydecks->last()->id) }}">{{ $project->copydecks->last()->name }}</a> @endif</td>
                <td>
                    @if(\Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a class="button tiny warning" href="{{ route('project.archive', $project->id) }}"><span class="fi-folder" title="archive" aria-hidden="true"></span> Archive</a>
                    @endif
                    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a href="{{ route('project.edit', $project->id) }}" class="button tiny"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Modify</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No projects active for this client.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <h4>{{ $archived->count() }} Archived projects</h4>
    <table>
        <thead>
        <tr>
            <th width="200">Project</th>
            <th width="100" class="center">Copydecks</th>
            <th>Last copydeck</th>
            <th width="250">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($archived as $project)
            <tr>
                <td><a href="{{ route('project.show', [$project->id]) }}">{{ $project->name }}</a></td>
                <?php $nbCd = $project->copydecks->count(); ?>
                <td class="center">{{ $nbCd }}</td>
                <td>@if($nbCd) <a href="{{ route('copydeck.show', $project->copydecks->last()->id) }}">{{ $project->copydecks->last()->name }}</a> @endif</td>
                <td>
                    @if(\Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a class="button tiny success" href="{{ route('project.publish', $project->id) }}"><span class="fi-history" title="republish" aria-hidden="true"></span> Republish</a>
                    @endif
                    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                        <a href="{{ route('project.edit', $project->id) }}" class="button tiny"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Modify</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No projects archived for this client.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <h4>Other actions</h4>
    @if(\Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
    <a class="button tiny round left" href="{{ route('client.edit', $client->id) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Edit client</a>
    <a class="button tiny round alert deleteEl"
       data-route="{{ route('client.destroy', $client->id) }}"
       data-redirect="{{ route('admin') }}"
       data-token="{{ csrf_token() }}"
       data-type="client"><span class="fi-delete" title="delete" aria-hidden="true"></span> Delete client</a>
    @endif
@stop