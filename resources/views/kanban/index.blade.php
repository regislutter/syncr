@extends('layouts.master')

@section('title', 'Kanban')

<?php
    $users = ['Célia', 'François', 'Martin', 'Danilo', 'Yannick', 'Régis', 'Florent'];
    $nbUsers = count($users);
    $status = ['Stalled', 'In progress', 'Done', 'Stash']; // 'To be tested', 'To be validated',
?>

@section('content')

    {{--<a class="button small round right" href="{{ route('user.create') }}">Create new task</a>--}}
    <h1>Oppa Kanban Style</h1>
    <div id="depot-tickets" class="depot">
        <div class="ticket fi-brush">Ticket Design</div>
        <div class="ticket fi-bug">Ticket Bug</div>
        <div class="ticket fi-cogs">Ticket Functionnality</div>
        <div class="ticket fi-project">Ticket Project Management</div>
        <div class="ticket fi-fork">Ticket Deployment</div>
    </div>
    <table>
        <thead>
        <tr>
            <th>Status</th>
            @foreach($users as $user)
            <th>{{ $user }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($status as $st)
            <?php $stName = str_replace(' ', '-', strtolower($st)); ?>
            <tr>
                <td>{{ $st }}</td>
                <?php $i = -1; ?>
                @while($i++ < $nbUsers-1)
                    <td class="user-tickets {{ $users[$i]=='Florent'?$stName.' own-tickets':$stName }}">
                        <div class="ticket">Ticket {{ $stName }}{{ $users[$i] }}</div>
                        <div class="ticket">Ticket {{ $stName }}{{ $users[$i] }}2</div>
                    </td>
                @endwhile
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