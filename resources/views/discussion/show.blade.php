@extends('layouts.master')

@section('title', 'Discussion : ' . $discussion->title)

@section('content')
    <h1>{{ $discussion->title }}</h1>
    @if(isset($discussion->project_id))
    <div class="small">Project: <a href="{{ route('project.show', $discussion->project_id) }}">{{ $discussion->project->name }}</a></div>
    @endif
    @if(isset($discussion->copydeck_id))
    <div class="small">Copydeck: <a href="{{ route('project.show', $discussion->copydeck_id) }}">{{ $discussion->copydeck->name }}</a></div>
    @endif

    <table>
        <thead>
        <tr>
            <th width="200">Author</th>
            <th>Message</th>
        </tr>
        </thead>
        <tbody>
        @foreach($discussion->direct_messages as $message)
            <tr>
                <td rowspan="2">
                    {{ $message->user->name }}
                </td>
                <td>
                    {!! $message->content !!}

                    @if($message->messages->count() > 0)
                    <table>
                        <tbody>
                        @foreach($message->messages as $response)
                            <tr>
                                <td>
                                    {{ $message->user->name }}
                                </td>
                                <td class="right">
                                    <a href="#">Edit</a> - <a href="#">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {!! $response->content !!}
                                </td>
                            </tr>
                        @endforeach
                            <tr>
                                <td colspan="2">
                                    <a href="{{ route('discussion.message.respond', [$discussion->id, $message->id]) }}">Respond</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="right">
                    @if($message->messages->count() == 0)<a href="{{ route('discussion.message.respond', [$discussion->id, $message->id]) }}">Respond</a>@endif - <a href="#">Edit</a> - <a href="#">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('discussion.message.create', [$discussion->id]) }}" class="button tiny round">New message</a>
@stop