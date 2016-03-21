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
        </tr>
        </thead>
        <tbody>
        @forelse($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->getCategory() }}</td>
                <td>{{ $ticket->getStatus() }}</td>
                <td>{{ $ticket->getPriority() }}</td>
                <td>{{ $ticket->getEstimate() }}</td>
                <td>{{ date('d M Y', strtotime($ticket->date_start)) }}</td>
                <td>{{ date('d M Y', strtotime($ticket->date_end)) }}</td>
                <td>{{ $ticket->user->name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">No tickets yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@stop