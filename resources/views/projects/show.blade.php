@extends('layouts.master')

@section('title', 'Project : ' . $project->name)

@section('content')
    <h1><img data-src="/images/svg/smart/grid.svg" class="iconic iconic-md" alt="grid"> {{ $project->name }}</h1>
    <div class="small">Client: <a href="{{ route('client.show', $project->client->id) }}">{{ $project->client->name }}</a></div>
    @if(\Auth::user()->is(\App\Role::WATCHER) || \Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::DEVELOPER) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
        @if(\Auth::user()->isSubscribed($project->id))
            <a class="button small round warning right" href="{{ route('unsubscribe.project', $project->id) }}"><span class="fi-eye-closed icon-bigger" title="unfollow" aria-hidden="true"></span> Unsubscribe</a>
        @else
            <a class="button small round success right" href="{{ route('subscribe.project', $project->id) }}"><span class="fi-eye-open icon-bigger" title="follow" aria-hidden="true"></span> Subscribe</a>
        @endif
    @endif
    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
    <a class="button small round right" href="{{ route('copydeck.create', $project->id) }}"><span class="fi-plus" title="star" aria-hidden="true"></span> Create a new copydeck</a>
    @endif
    <h4>{{ $project->copydecks->count() }} Copydecks</h4>
    <table>
        <thead>
        <tr>
            <th width="200">Copydeck</th>
            <th>File name</th>
            <th>Server links</th>
            <th width="150">Last version</th>
            <th width="150">Deployed version</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @forelse($project->copydecks as $copydeck)
            <tr>
                <td><a href="{{ route('copydeck.show', [$copydeck->id]) }}">{{ $copydeck->name }}</a></td>
                <?php $file = $copydeck->files->last(); ?>
                <td>
                    {{ substr($file->link, strrpos($file->link, '/')+1) }}
                </td>
                <td>
                    <a class="label round" href="{{ substr($file->link, 0, strrpos($file->link, '/')) }}"><span class="fi-browser-type-safari" title="safari" aria-hidden="true"></span> Safari users</a>
                    <a class="copy-button label round" data-clipboard-text="{{ substr($file->link, 0, strrpos($file->link, '/')) }}" title="Click to copy the path."><span class="fi-browser-type-chrome" title="chrome" aria-hidden="true"></span> Other browsers</a>
                </td>
                <td>{{ $file->version }} - {{ $file->getStatusText() }}<br/><span class="small">{{ date('d M Y', strtotime($file['created_at']->toDateTimeString())) }}</span></td>
                <?php $lastFile = $copydeck->files()->where('status', \App\File::STATUS_DEPLOYED)->orderBy('status_updated_at', 'desc')->first(); ?>
                <td>@if($lastFile) {{ $lastFile->version }} <span class="small">- {{ date('d M Y', strtotime($lastFile->status_updated_at->toDateTimeString())) }}</span> @else None @endif</td>
                <td>
                    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                    <a href="{{ route('file.create', [$project->id, $copydeck->id]) }}" class="button tiny"><span class="fi-data-transfer-upload" title="upload" aria-hidden="true"></span> New version</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No copydeck in this project.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <h4>Other actions</h4>
    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
        <a class="button tiny round left" href="{{ route('project.edit', $project->id) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Edit project</a>
        <a class="button tiny round alert deleteEl"
           data-route="{{ route('project.destroy', $project->id) }}"
           data-redirect="{{ route('client.show', $project->client->id) }}"
           data-token="{{ csrf_token() }}"
            data-type="project"><span class="fi-delete" title="delete" aria-hidden="true"></span> Delete project</a>
    @endif
@stop