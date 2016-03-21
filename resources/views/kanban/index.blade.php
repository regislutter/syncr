@extends('layouts.master')

@section('title', 'Kanban')

<?php
    $users = ['Célia', 'François', 'Martin', 'Danilo', 'Yannick', 'Régis', 'Testing'];
    $nbUsers = count($users);
    $status = ['Ready', 'In progress', 'Revision', 'Done']; // 'To be tested', 'To be validated',
?>

@section('content')

    {{--<a class="button small round right" href="{{ route('user.create') }}">Create new task</a>--}}
    <h1>Oppa Kanban Style</h1>
    <div id="depot-tickets" class="depot">
        <a class="new-ticket button tiny round right fi-plus" href="{{ route('user.create') }}">New ticket</a>
        <h2>Backlog</h2>
        <div class="ticket fi-brush prio-low">Ticket Design</div>
        <div class="ticket fi-bug prio-middle">Ticket Bug</div>
        <div class="ticket fi-cogs prio-high">Ticket Functionnality</div>
        <div class="ticket fi-project">Ticket Project Management</div>
        <div class="ticket fi-fork">Ticket Deployment</div>
    </div>
    <table class="kanban">
        <thead>
        <tr>
            <th>Status</th>
            @foreach($users as $user)
            <th>{{ $user }}</th>
            @endforeach
            <th>Overflow</th>
        </tr>
        </thead>
        <tbody>
        @foreach($status as $st)
            <?php $stName = str_replace(' ', '-', strtolower($st)); ?>
            <tr>
                <td>{{ $st }}</td>
                <?php $i = -1; ?>
                @while($i++ < $nbUsers-1)
                    <td class="user-tickets {{ $users[$i]=='Testing'?'own-tickets '.$stName:$stName }}">
                        <div class="ticket">Ticket {{ $stName }}{{ $users[$i] }}</div>
                        <div class="ticket">Ticket {{ $stName }}{{ $users[$i] }}2</div>
                    </td>
                @endwhile
                <td class="user-tickets own-tickets {{ $stName }}"></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop

@section('javascript')
    <?php
        $rightMoveOwnTickets = true;
        $rightTakeDepot = true;
        $rightDropDepot = false;
        $rightMoveAllTickets = false;

        $listRightsMoveFrom = [];
        $listRightsMoveTo = [];
        if($rightMoveOwnTickets){ array_push($listRightsMoveFrom, '.own-tickets'); array_push($listRightsMoveTo, '.own-tickets'); }
        if($rightTakeDepot){ array_push($listRightsMoveFrom, '#depot-tickets'); }
        if($rightTakeDepot && $rightDropDepot){ array_push($listRightsMoveTo, '#depot-tickets'); }
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
                }
            }).disableSelection();
        });
    </script>
@stop