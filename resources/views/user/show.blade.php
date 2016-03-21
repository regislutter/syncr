@extends('layouts.master')

@section('title', 'My Profile')

@section('content')

    <div class="row">
        @if(isset($user->avatar))
        <div class="large-2 columns">
            <img class="avatar" src="/images/users/{{ $user->avatar }}" />
        </div>
        <div class="large-10 columns">
        @else
        <div class="large-12 columns">
        @endif
            <div class="row">
                <div class="large-12 columns">
                    Name: {{ $user->name }}
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                </div>
            </div>
            @if(isset($user->title) && !empty($user->title))
            <div class="row">
                <div class="large-12 columns">
                    Title/Job: {{ $user->title }}
                </div>
            </div>
            @endif
            @if(isset($user->phone) && !empty($user->phone) || isset($user->phonepost) && !empty($user->phonepost))
            <div class="row">
                <div class="large-12 columns">
                    @if(isset($user->phone) && !empty($user->phone)) Phone: {{ $user->phone }} @endif
                    @if(isset($user->phone) && !empty($user->phone) && isset($user->phonepost) && !empty($user->phonepost)) - @endif
                    @if(isset($user->phonepost) && !empty($user->phonepost)) Internal post : {{ $user->phonepost }} @endif
                </div>
            </div>
            @endif
            @if(isset($user->hobbies) && !empty($user->hobbies))
            <div class="row">
                <div class="large-12 columns">
                    Hobbies: {{ $user->hobbies }}
                </div>
            </div>
            @endif
        </div>
    </div>

        <h4>Tickets</h4>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Project</th>
            <th>Category</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Estimate</th>
            <th>Date start</th>
            <th>Deadline</th>
        </tr>
        </thead>
        <tbody>
        @forelse($user->tickets as $ticket)
            <tr>
                <td><a href="{{ route('ticket.show', [$ticket->id]) }}">{{ $ticket->name }}</a></td>
                <td><a href="{{ route('project.show', $ticket->project->id) }}">{{ $ticket->project->name }}</a></td>
                <td>{{ $ticket->getCategory() }}</td>
                <td>{{ $ticket->getStatus() }}</td>
                <td>{{ $ticket->getPriority() }}</td>
                <td>{{ $ticket->getEstimate() }}</td>
                <td>{{ $ticket->getDateStart() }}</td>
                <td>{{ $ticket->getDateEnd() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No tickets yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @if($user->id == Auth::user()->id)
        <a class="button small round" href="{{ route('user.edit', $user->id) }}">Edit my profile</a>
    @elseif(\Auth::user()->hasRight(\App\Right::USER_MODIFY))
        <a class="button small round" href="{{ route('user.edit', $user->id) }}">Edit user</a>
    @endif

@stop