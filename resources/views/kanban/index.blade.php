@extends('layouts.master')

@section('title', 'Kanban')

<?php $nbUsers = count($users); ?>

@section('content')

    <h1>Oppa Kanban Style</h1>
    <div class="backlog">
        <a class="new-ticket button tiny round right fi-plus" href="{{ route('ticket.create') }}">New ticket</a>
        <h2>Backlog</h2>
        <div id="backlog-tickets" data-statusid="0" data-userid="0">
            @forelse($ticketsbacklog as $tb)
                @include ('kanban.ticket', ['ticket' => $tb])
                <p class="no-tickets hide">No tickets available.</p>
            @empty
                <p class="no-tickets">No tickets available.</p>
            @endforelse
        </div>
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
                    <td data-statusid="{{ $statusid }}" data-userid="{{ $user->id }}" class="user-tickets @if($user->id === \Auth::user()->id) own-tickets @endif">
                        <?php $userTickets = $tickets->filter(function($ticket) use($user, $statusid) {
                            if($ticket->user_id === $user->id && $ticket->status == $statusid){ return true; }
                        }); ?>
                        @foreach($userTickets as $userTicket)
                            @include ('kanban.ticket', ['ticket' => $userTicket])
                        @endforeach
                    </td>
                @endforeach
                <td data-statusid="{{ $statusid }}" data-userid="0" class="user-tickets own-tickets">
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
            @if($refresh)
                setTimeout(function(){
                    window.location.reload(1);
                }, 300000);
            @endif

            // CSRF protection
            $.ajaxSetup({
                headers:
                {
                    'X-CSRF-Token': '{{ \Session::token() }}'
                }
            });

            $( "{{ join(', ', $listRightsMoveFrom) }}" ).sortable({
                connectWith: ["{!! join('", "', $listRightsMoveTo) !!}"],
                placeholder: "ui-state-highlight",
                receive: function(event, ui){
                    var recepter = $(event.target);
                    if(recepter.data('statusid') == '3' && recepter.children().length > 2){
                        ui.sender.sortable( "cancel" );
                    } else {
                        if(recepter.attr('id') == 'backlog-tickets'){
                            $('.no-tickets').addClass('hide');
                        }else if(ui.sender.children('.ticket').length <= 0){
                            $('.no-tickets').removeClass('hide');
                        }
                        var dataUpdate = {
                            'id': $(ui.item).data('ticketid'),
                            'status': recepter.data('statusid'),
                            'user': recepter.data('userid'),
                        };
                        $.post('{{ route('ticket.drag') }}', dataUpdate).fail(function(){
                            swal("Ticket not updated...", "An error occured while updating the ticket. Please refer to the administrator if the error persist.", "error");
                        });
                    }
                }
            }).disableSelection();

            $('.ticket').on('click', function(e){
                var ticketid = $(this).data('ticketid');

                var dataInfos = {
                    'id': ticketid
                };
                $.post('{{ route('ticket.infos') }}', dataInfos)
                .done(function(ticket){ // On request success, display ticket infos
                    swal({
                        title: ticket.name,
                        text: ticket.description,
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
                })
                .fail(function(){ // On request failed, display error
                    swal("Ticket not found...", "An error occured while retrieving the ticket's data or the ticket doesn't exist. Please refer to the administrator if the error persist.", "error");
                });
            });
        });
    </script>
@stop