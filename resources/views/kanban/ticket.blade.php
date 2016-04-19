<div data-ticketid="{{ $ticket->id }}" class="ticket {{ $ticket->getCategoryIconClass() }} {{ $ticket->getPriorityColorClass() }}">
    @if($ticket->project)<div class="ticket-project">{{ $ticket->project->name }}</div>@endif
    <div class="ticket-title">{{ $ticket->name }}</div>

    <div class="ticket-dates">
        <div class="ticket-date-start">{{ $ticket->getDateStart() }}</div>
        <div class="ticket-estimate">{{ $ticket->getEstimate() }}</div>
        <div class="ticket-date-end">{{ $ticket->getDateEnd() }}</div>
    </div>
</div>