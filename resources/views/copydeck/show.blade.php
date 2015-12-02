@extends('layouts.master')

@section('title', 'Copydeck : '.$copydeck->name)

@section('content')
    <h1>{{ $copydeck->name }}</h1>
    <div class="small">Project: <a href="{{ route('project.show', $copydeck->project->id) }}">{{ $copydeck->project->name }}</a></div>
    <div class="small">Client: <a href="{{ route('client.show', $copydeck->project->client->id) }}">{{ $copydeck->project->client->name }}</a></div>
    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
    <a class="button small round right" href="{{ route('file.create', [$copydeck->project->id, $copydeck->id]) }}"><span class="fi-plus" title="star" aria-hidden="true"></span> New version</a>
    @endif
    <h4>{{ $copydeck->files->count() }} Versions</h4>
    <table>
        <thead>
        <tr>
            <th>File name</th>
            <th width="70">Version</th>
            <th>Status</th>
            <th>Date</th>
            <th>Server folder links</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($copydeck->files->reverse() as $file)
            @if($file->id == $copydeck->development_file_id)
            <tr class="enlighten">
            @else
            <tr>
            @endif
                <td>
                    {{ substr($file->link, strrpos($file->link, '/')+1) }}
                </td>
                <td class="center">{{ $file->version }}</td>
                <td>{{ $file->getStatusText() }}</td>
                <td>{{ date('d M Y', strtotime($file['created_at']->toDateTimeString())) }}</td>
                <td>
                    <a class="label round" href="{{ substr($file->link, 0, strrpos($file->link, '/')) }}"><span class="fi-browser-type-safari" title="safari" aria-hidden="true"></span> Safari users</a>
                    <a class="copy-button label round" data-clipboard-text="{{ substr($file->link, 0, strrpos($file->link, '/')) }}" title="Click to copy the path."><span class="fi-browser-type-chrome" title="chrome" aria-hidden="true"></span> Other browsers</a>
                </td>
                <td>
                    @if((\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::SUPER_ADMIN)) && $file->status == \App\File::STATUS_READY)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_IN_EDITION]) }}" class="button tiny warning"><span class="fi-pencil" title="edition" aria-hidden="true"></span> Back to edition</a>
                    @endif
                    @if((\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::SUPER_ADMIN)) && $file->status == \App\File::STATUS_IN_EDITION)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_READY]) }}" class="button tiny success"><span class="fi-circle-check" title="ready" aria-hidden="true"></span> Ready for development</a>
                    @endif
                    @if((\Auth::user()->is(\App\Role::DEVELOPER) || \Auth::user()->is(\App\Role::SUPER_ADMIN)) && $file->status == \App\File::STATUS_READY)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_IN_DEVELOPMENT]) }}" class="button tiny"><span class="fi-code" title="code" aria-hidden="true"></span> Starting development</a>
                    @endif
                    @if((\Auth::user()->is(\App\Role::DEVELOPER) || \Auth::user()->is(\App\Role::SUPER_ADMIN)) && $file->status == \App\File::STATUS_IN_DEVELOPMENT)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_DEPLOYED]) }}" class="button tiny success"><span class="fi-circle-check" title="done" aria-hidden="true"></span> Development deployed</a>
                    @endif
                    @if($file->status == \App\File::STATUS_DEPLOYED)
                        Deployed the {{ date('d M Y', strtotime($file->status_updated_at->toDateTimeString())) }}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No files found in this copydeck. Please contact the administrator.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <h4>Discussion</h4>
    <div class="panel">
        <span class="round label">Coming soon...</span>
    </div>
    <h4>Other actions</h4>
    @if(\Auth::user()->is(\App\Role::EDITOR) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
        <a class="button tiny round" href="{{ route('copydeck.edit', $copydeck->id) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Edit copydeck</a>
        <a class="button tiny round alert deleteEl"
           data-route="{{ route('project.destroy', $copydeck->id) }}"
           data-redirect="{{ route('project.show', $copydeck->project->id) }}"
           data-token="{{ csrf_token() }}"
           data-type="project"><span class="fi-delete" title="delete" aria-hidden="true"></span> Delete copydeck</a>
    @endif
@stop