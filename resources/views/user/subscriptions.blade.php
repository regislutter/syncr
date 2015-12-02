@extends('layouts.master')

@section('title', 'My subscriptions')

@section('content')
    <h4>{{ $user->subscriptions->count() }} Subscriptions</h4>
    <table>
        <thead>
        <tr>
            <th>Project</th>
            <th width="100" class="center">Copydecks</th>
            <th width="200">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $noSub = true; ?>
        @forelse($user->subscriptions as $sub)
            @if($sub->project->archived == 0)
                <?php $project = $sub->project; $noSub = false; ?>
                <tr>
                    <td><a href="{{ route('project.show', $project->id) }}">{{ $project->name }}</a></td>
                    <td class="center">{{ $project->copydecks->count() }}</td>
                    <td><a class="button tiny warning" href="{{ route('unsubscribe.project', $project->id) }}"><span class="fi-eye-closed" title="unfollow" aria-hidden="true"></span> Unsubscribe</a></td>
                </tr>
            @endif
        @empty
            <?php $noSub = false; ?>
            <tr>
                <td colspan="3">No subscriptions.</td>
            </tr>
        @endforelse
        @if($noSub)
            <tr>
                <td colspan="3">No subscriptions on active projects.</td>
            </tr>
        @endif
        </tbody>
    </table>
@stop