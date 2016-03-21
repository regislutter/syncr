@extends('layouts.master')

@section('title', 'Kanban')

<?php $nbUsers = count($users); ?>

@section('content')

    <h1>Oppa Kanban Style</h1>
    <div id="backlog-tickets" class="backlog">
        <a class="new-ticket button tiny round right fi-plus" href="{{ route('ticket.create') }}">New ticket</a>
        <h2>Backlog</h2>

        @forelse($ticketsbacklog as $tb)
            @include ('kanban.ticket', ['ticket' => $tb])
            @empty
            <p>No tickets available.</p>
        @endforelse
    </div>
    <table class="kanban">
        <thead>
        <tr>
            <th>Status</th>
            @foreach($users as $user)
            <th>{{ $user->name }}</th>
            @endforeach
            <th>Overflow</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statuses as $statusid => $status)
            <tr>
                <td>{{ $status }}</td>
                @foreach($users as $user)
                    <td class="user-tickets status-{{ $statusid }} @if($user->id === \Auth::user()->id) own-tickets @endif">
                        <?php $userTickets = $tickets->filter(function($ticket) use($user, $statusid) {
                            if($ticket->user_id === $user->id && $ticket->status == $statusid){ return true; }
                        }); ?>
                        @foreach($userTickets as $userTicket)
                            @include ('kanban.ticket', ['ticket' => $userTicket])
                        @endforeach
                    </td>
                @endforeach
                <td class="user-tickets status-{{ $statusid }} own-tickets">
                    <?php $noUserTickets = $tickets->filter(function($ticket) use($statusid) {
                        if($ticket->user_id === 0 && $ticket->status == $statusid){ return true; }
                    }); ?>
                    @foreach($noUserTickets as $noUserTicket)
                        @include ('kanban.ticket', ['ticket' => $noUserTicket])
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop

@section('javascript')
    <?php
        $rightMoveOwnTickets = \Auth::user()->hasRight(\App\Right::TICKET_MOVE_OWN);
        $rightTakeBacklog = \Auth::user()->hasRight(\App\Right::TICKET_TAKE_BACKLOG);
        $rightDropBacklog = \Auth::user()->hasRight(\App\Right::TICKET_DROP_BACKLOG);
        $rightMoveAllTickets = \Auth::user()->hasRight(\App\Right::TICKET_MOVE_ALL);

        $listRightsMoveFrom = [];
        $listRightsMoveTo = [];
        if($rightMoveOwnTickets){ array_push($listRightsMoveFrom, '.own-tickets'); array_push($listRightsMoveTo, '.own-tickets'); }
        if($rightTakeBacklog){ array_push($listRightsMoveFrom, '#backlog-tickets'); }
        if($rightDropBacklog){ array_push($listRightsMoveTo, '#backlog-tickets'); }
        if($rightMoveAllTickets){ array_push($listRightsMoveFrom, '.user-tickets'); array_push($listRightsMoveTo, '.user-tickets'); }
    ?>
    <script type="text/javascript">
        $(function() {
            $( "{{ join(', ', $listRightsMoveFrom) }}" ).sortable({
                connectWith: ["{!! join('", "', $listRightsMoveTo) !!}"],
                placeholder: "ui-state-highlight",
                receive: function(event, ui){
                    var recepter = $(event.target);
                    if(recepter.hasClass('in-progress') && recepter.children().length > 2){
                        ui.sender.sortable( "cancel" );
                    }

                    // TODO Ajax request
                    // TODO If fail, sortable("cancel") + swal alert
                }
            }).disableSelection();

            @if(\Auth::user()->hasRight(\App\Right::TICKET_DELETE))
                $('.ticket').on('click', function(e){
                    var ticketid = $(this).data('ticketid');
                    swal({
                        title: "Ajax request example",
                        text: "Submit to run ajax request",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        cancelButtonText: "Close",
                        confirmButtonText: "Edit it",
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            var url = '{{ route('ticket.edit', '##ticketid##') }}'.replace('##ticketid##', ticketid);
                            window.location.href = url;
                            return false;
                        }
                    });
                });
            @else
                $('.ticket').on('click', function(e){
                    var ticket = $(e.target);
                    swal({
                        title: "Ajax request example",
                        text: "Submit to run ajax request",
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: "Close"
                    });
                });
            @endif
        });
    </script>
@stop