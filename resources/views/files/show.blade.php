@extends('layouts.master')

@section('title', 'Copydeck '.$copydeck->name.' v'.$file->version)

@section('content')
    <!-- TODO Add Title, etc. -->
    <div class="row">
        <div class="large-12 columns">
            <div class="panel">
                {!! $file->content !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <h2>Actions</h2>
            @if(empty($file->link) && \Auth::user()->hasRight(\App\Right::VERSION_MODIFY) && $file->status == \App\File::STATUS_IN_EDITION)
                <a href="{{ route('file.edit', [$file->id]) }}" class="button tiny">Modify</a>
            @endif
            @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_IN_EDITION) && $file->status == \App\File::STATUS_READY)
                <a href="{{ route('file.status', [$file->id, \App\File::STATUS_IN_EDITION]) }}" class="button tiny warning"><span class="fi-pencil" title="edition" aria-hidden="true"></span> Back to edition</a>
            @endif
            @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_READY) && $file->status == \App\File::STATUS_IN_EDITION)
                <a href="{{ route('file.status', [$file->id, \App\File::STATUS_READY]) }}" class="button tiny success"><span class="fi-circle-check" title="ready" aria-hidden="true"></span> Ready for development</a>
            @endif
            @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_IN_DEVELOPMENT) && $file->status == \App\File::STATUS_READY)
                <a href="{{ route('file.status', [$file->id, \App\File::STATUS_IN_DEVELOPMENT]) }}" class="button tiny"><span class="fi-code" title="code" aria-hidden="true"></span> Starting development</a>
            @endif
            @if(\Auth::user()->hasRight(\App\Right::VERSION_STATUS_TO_DEPLOYED) && $file->status == \App\File::STATUS_IN_DEVELOPMENT)
                <a href="{{ route('file.status', [$file->id, \App\File::STATUS_DEPLOYED]) }}" class="button tiny success"><span class="fi-circle-check" title="done" aria-hidden="true"></span> Development deployed</a>
            @endif
            @if($file->status == \App\File::STATUS_DEPLOYED)
                Deployed the {{ date('d M Y', strtotime($file->status_updated_at->toDateTimeString())) }}
            @endif
        </div>
    </div>
@stop