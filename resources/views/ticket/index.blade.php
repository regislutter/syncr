@extends('layouts.master')

@section('title', 'Tickets list')

@section('content')
    <a class="button small round right" href="{{ route('ticket.create') }}">New ticket</a>
    <h1>Tickets list</h1>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Estimate</th>
            <th>Date start</th>
            <th>Deadline</th>
            <th>User</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($tickets as $ticket)
            <tr>
                <td><a href="{{ route('ticket.show', [$ticket->id]) }}">{{ $ticket->name }}</a></td>
                <td>{{ $ticket->getCategory() }}</td>
                <td>{{ $ticket->getStatus() }}</td>
                <td>{{ $ticket->getPriority() }}</td>
                <td>{{ $ticket->getEstimate() }}</td>
                <td>{{ $ticket->getDateStart() }}</td>
                <td>{{ $ticket->getDateEnd() }}</td>
                <td><a href="{{ route('user.show', [$ticket->user->id]) }}">{{ $ticket->user->name }}</a></td>
                <td>
                    @if(\Auth::user()->hasRight(\App\Right::TICKET_MODIFY))
                        <a href="{{ route('ticket.update', [$ticket->id]) }}" class="button tiny"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Edit</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">No tickets yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop