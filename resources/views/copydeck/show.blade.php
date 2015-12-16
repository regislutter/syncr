@extends('layouts.master')

@section('title', 'Copydeck : '.$copydeck->name)

@section('content')
    <h1>{{ $copydeck->name }}</h1>
    <div class="small">Project: <a href="{{ route('project.show', $copydeck->project->id) }}">{{ $copydeck->project->name }}</a></div>
    <div class="small">Client: <a href="{{ route('client.show', $copydeck->project->client->id) }}">{{ $copydeck->project->client->name }}</a></div>
    @if(\Auth::user()->hasRight(\App\Right::VERSION_CREATE))
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
                    @if(empty($file->link))
                        <a href="{{ route('file.show', $file->id) }}"><strong>Online version</strong></a>
                    @else
                        {{ substr($file->link, strrpos($file->link, '/')+1) }}
                    @endif
                </td>
                <td class="center">{{ $file->version }}</td>
                <td>{{ $file->getStatusText() }}</td>
                <td>{{ date('d M Y', strtotime($file['created_at']->toDateTimeString())) }}</td>
                <td>
                    <a class="label round" href="{{ substr($file->link, 0, strrpos($file->link, '/')) }}"><span class="fi-browser-type-safari" title="safari" aria-hidden="true"></span> Safari users</a>
                    <a class="copy-button label round" data-clipboard-text="{{ substr($file->link, 0, strrpos($file->link, '/')) }}" title="Click to copy the path."><span class="fi-browser-type-chrome" title="chrome" aria-hidden="true"></span> Other browsers</a>
                </td>
                <td>
                    @if(empty($file->link) && \Auth::user()->hasRight(\App\Right::VERSION_MODIFY) && $file->status == \App\File::STATUS_IN_EDITION)
                        <a href="{{ route('file.edit', $file->id) }}" class="button tiny">Modify</a>
                    @endif
                    @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_IN_EDITION) && $file->status == \App\File::STATUS_READY)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_IN_EDITION]) }}" class="button tiny warning"><span class="fi-pencil" title="edition" aria-hidden="true"></span> Back to edition</a>
                    @endif
                    @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_READY) && $file->status == \App\File::STATUS_IN_EDITION)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_READY]) }}" class="button tiny success"><span class="fi-circle-check" title="ready" aria-hidden="true"></span> Ready for development</a>
                    @endif
                    @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_IN_DEVELOPMENT) && $file->status == \App\File::STATUS_READY)
                        <a href="{{ route('file.status', [$file->id, \App\File::STATUS_IN_DEVELOPMENT]) }}" class="button tiny"><span class="fi-code" title="code" aria-hidden="true"></span> Starting development</a>
                    @endif
                    @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_DEPLOYED) && $file->status == \App\File::STATUS_IN_DEVELOPMENT)
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

    <h4>Discussions</h4>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th width="100">Number of messages</th>
            <th width="150">Date last message</th>
            <th width="150">Date first message</th>
            <th width="150">Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($copydeck->discussions as $discussion)
            <tr>
                <td><a href="{{ route('discussion.show', [$discussion->id]) }}">{{ $discussion->title }}</a></td>
                <td>{{ $discussion->direct_messages->count() }}</td>

                <?php $lastMessage = $discussion->direct_messages()->orderBy('created_at', 'desc')->first(); ?>
                <td>@if($lastMessage) {{ date('d M Y', strtotime($lastMessage->created_at->toDateTimeString())) }} @else None @endif</td>
                <td>{{ date('d M Y', strtotime($discussion->created_at->toDateTimeString())) }}</td>
                <td>
                    @if(\Auth::user()->hasRight(\App\Right::DELETE_DISCUSSION))
                        <a class="button tiny round alert" href="#">Close</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No discussion in this copydeck. <a href="{{ route('copydeck.discussion.create', [$copydeck->project->id, $copydeck->id]) }}">Open the first discussion</a></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if(\Auth::user()->hasRight(\App\Right::CREATE_DISCUSSION))
        <a class="button tiny round left" href="{{ route('copydeck.discussion.create', [$copydeck->project->id, $copydeck->id]) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Create new discussion</a>
    @endif
    <br/><br/>
    <h4>Other actions</h4>
    @if(\Auth::user()->hasRight(\App\Right::COPYDECK_MODIFY))
        <a class="button tiny round" href="{{ route('copydeck.edit', $copydeck->id) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Edit copydeck</a>
    @endif
    @if(\Auth::user()->hasRight(\App\Right::COPYDECK_DELETE))
        <a class="button tiny round alert deleteEl"
           data-route="{{ route('project.destroy', $copydeck->id) }}"
           data-redirect="{{ route('project.show', $copydeck->project->id) }}"
           data-token="{{ csrf_token() }}"
           data-type="project"><span class="fi-delete" title="delete" aria-hidden="true"></span> Delete copydeck</a>
    @endif
@stop