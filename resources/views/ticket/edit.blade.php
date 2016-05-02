@extends('layouts.master')

@section('title', 'Edit ticket: '.$ticket->name)

@section('content')
    <h1>Edit ticket:</h1>
    <h2>{{ $ticket->name }}</h2>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($ticket, array('url' => route('ticket.update', $ticket->id), 'method' => 'put')) !!}

    <div class="row">
        <div class="large-12 columns">
            {!! Form::label('name', 'Name*') !!}{!! Form::text('name') !!}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            {!! Form::label('description', 'Description') !!}{!! Form::textarea('description') !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            {!! Form::label('project_id', 'Project') !!}{!! Form::select('project_id', $projects) !!}
        </div>
        <div class="large-6 medium-6 columns">
            {!! Form::label('category', 'Category*') !!}{!! Form::select('category', $categories) !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            {!! Form::label('status', 'Status') !!}{!! Form::select('status', $statuses) !!}
        </div>
        <div class="large-6 medium-6 columns">
            {!! Form::label('user_id', 'User') !!}{!! Form::select('user_id', $users) !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            {!! Form::label('priority', 'Priority') !!}{!! Form::select('priority', $priorities) !!}
        </div>
        <div class="large-6 medium-6 columns">
            {!! Form::label('estimate', 'Estimate') !!}{!! Form::select('estimate', $estimates) !!}
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            {!! Form::label('date_start', 'Date start') !!}{!! Form::input('date', 'date_start', date('Y-m-d', strtotime($ticket->date_start))) !!}
        </div>
        <div class="large-6 medium-6 columns">
            {!! Form::label('date_end', 'Deadline') !!}{!! Form::input('date', 'date_end', date('Y-m-d', strtotime($ticket->date_end))) !!}
        </div>
    </div>
    <a class="button small round secondary" href="{{ URL::previous() }}">Cancel</a>
    {!! Form::submit('Update ticket', array('class' => 'button small round success')) !!}

    {!! Form::close() !!}

    {!! Form::open(array('route' => array('ticket.destroy', $ticket->id), 'method' => 'delete', 'id' => 'delete-form')) !!}
    {!! Form::close() !!}
    <div id="delete-btn" class="button small round alert right">Delete</div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(function() {
            $('#delete-btn').on('click', function(){
                swal({
                    title: 'Are you sure to delete {{ $ticket->name }}?',
                    text: 'You will not be able to recover this awesome ticket!',
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "No, that's crazy!",
                    confirmButtonText: "Yes, delete it.",
                },
                function(isConfirm){
                    if (isConfirm) {
                        $('#delete-form').submit();
                        return false;
                    }
                });
            });
        });
    </script>
@stop