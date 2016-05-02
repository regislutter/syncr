@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <!-- TICKETS -->
    <a class="button small round right" href="{{ route('kanban') }}">Access Kanban dashboard</a>
    <h2>Tickets assigned</h2>
    <div id="list-tickets">
    @if($tickets)
        @foreach(\App\Ticket::$STATUSES as $statusid => $statusname)
            @if($statusid != \App\Ticket::STATUS_BACKLOG && $statusid != \App\Ticket::STATUS_DONE)
                <h3>{{ $statusname }}</h3>
                <?php $ticketsStatus = $tickets->filter(function($ticket) use ($statusid) {
                    if($ticket->status == $statusid){
                       return true;
                    }
                }); ?>
                @forelse($ticketsStatus as $ticket)
                    @include ('kanban.ticket', ['ticket' => $ticket])
                @empty
                    No tickets.
                @endforelse
            @endif
        @endforeach
    @else
        You don't have any tickets. Great job!
    @endif
    </div>
<br/><br/>

    <!-- COPYDECKS -->
    <h2>Copydecks</h2>
    <?php
    $lastDate = null;
    $listProject = [];
    $listCopydeck = []; ?>
    @if($filesUpdate == null)
        No copydecks to display.
    @else
        <dl class="sub-nav legend">
            <dt>Filter:</dt>
            <dd class="status @if($status == 'all') active @endif"><a href="{{ route('home') }}">All</a></dd>
            <dd class="status in-edition @if($status != 'all' && $status == \App\File::STATUS_IN_EDITION) active @endif"><a href="{{ route('home') }}?status={{ \App\File::STATUS_IN_EDITION }}">In edition</a></dd>
            <dd class="status ready @if($status==\App\File::STATUS_READY) active @endif"><a href="{{ route('home') }}?status={{ \App\File::STATUS_READY }}">Ready</a></dd>
            <dd class="status in-development @if($status==\App\File::STATUS_IN_DEVELOPMENT) active @endif"><a href="{{ route('home') }}?status={{ \App\File::STATUS_IN_DEVELOPMENT }}">In development</a></dd>
            <dd class="status deployed @if($status==\App\File::STATUS_DEPLOYED) active @endif"><a href="{{ route('home') }}?status={{ \App\File::STATUS_DEPLOYED }}">Deployed</a></dd>
            {{--<dd class="status"><a href="{{ route('home') }}">Unknown</a></dd>--}}
            <dd>||</dd>
            <dd class="status ready late">Late</dd>
            <dd class="status ready really late">Really late</dd>
        </dl>
        <div class="timeline">
        @foreach($filesUpdate as $file)
            <?php
                // Get file updated date
                $actualDate = date('dmY', strtotime($file['created_at']->toDateTimeString()));
                // Get file's copydeck project
                $copydeckId = $file->copydeck['id'];
                if(in_array($copydeckId, $listCopydeck)){
                    $copydeck = $listCopydeck[$copydeckId];
                }else{
                    $copydeck = \App\Copydeck::find($copydeckId);
                    $listCopydeck[$copydeckId] = $copydeck;
                }
                $projectId = $file->copydeck['project_id'];
                if(in_array($projectId, $listProject)){
                    $project = $listProject[$projectId];
                }else{
                    $project = \App\Project::find($projectId);
                    $listProject[$projectId] = $project;
                }
            ?>
            @if($lastDate == null || $lastDate != $actualDate)
                <?php $lastDate = $actualDate; ?>
                <div class="date">{{ date('l, d M Y', strtotime($file['created_at']->toDateTimeString())) }}</div>
            @endif
            <?php
                $statusClass = 'status unknown';
                switch($file->status){
                    case \App\File::STATUS_READY:
                        $statusClass = 'status ready';
                        break;
                    case \App\File::STATUS_IN_DEVELOPMENT:
                        $statusClass = 'status in-development';
                        break;
                    case \App\File::STATUS_DEPLOYED:
                        $statusClass = 'status deployed';
                        break;
                    default:
                        $statusClass = 'status in-edition';
                        break;
                }
                $now = time();
                $lastUpdate = strtotime($file->created_at);
                $datediff = $now - $lastUpdate;
                if(floor($datediff/(60*60*24)) > 15){
                    $statusClass .= ' late';
                    if(floor($datediff/(60*60*24)) > 30){
                        $statusClass .= ' really';
                    }
                }
            ?>
            <div class="copydeck {{ $statusClass }}">
                @if(!empty($project->image))
                <img src="{{ $project->image }}" />
                @else
                <img src="/images/default-project.png" />
                @endif
                <a href="{{ route('copydeck.show', $copydeckId) }}">{{ $file->copydeck['name'] }}</a> - V{{ $file->version }} <span class="small">by <a href="#">{{ $file->user->name }}</a></span>
                    <?php $fileDeployed = $copydeck->files()->where('status', \App\File::STATUS_DEPLOYED)->orderBy('updated_at', 'desc')->first(); ?>
                <div class="small lastversion">Last version deployed: @if($fileDeployed) <strong>{{ $fileDeployed->version }}</strong> on {{ date('l, d M Y', strtotime($fileDeployed->updated_at->toDateTimeString())) }} @else No version deployed @endif</div>
                <div class="small"><a href="{{ route('project.show', $project->id) }}">{{ $project->name }}</a></div>
            </div>
        @endforeach
        </div>
    @endif
@stop