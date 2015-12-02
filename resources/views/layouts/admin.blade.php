@extends('layouts.base')
    @section('page')
        <div class="container">
            <dl class="sub-nav">
                <dt>Administration:</dt>
                <dd class="{{ \App\Helpers\ActiveRoute::is_active('admin/') }}"><a href="{{ route('admin') }}"><span class="fi-cogs" title="parameters" aria-hidden="true"></span> Parameters</a></dd>
                @if(\Auth::user()->is(\App\Role::ADMIN) || \Auth::user()->is(\App\Role::SUPER_ADMIN))
                <dd class="{{ \App\Helpers\ActiveRoute::is_active('admin/clients') }}"><a href="{{ route('admin.clients') }}"><span class="fi-briefcase" title="clients" aria-hidden="true"></span> Manage clients</a></dd>
{{--                <dd class="{{ \App\Helpers\ActiveRoute::is_active('admin/projects') }}"><a href="{{ route('admin.projects') }}"><span class="fi-grid-three-up" title="projects" aria-hidden="true"></span> Manage projects</a></dd>--}}
                <dd class="{{ \App\Helpers\ActiveRoute::is_active('admin/users') }}"><a href="{{ route('admin.users') }}"><span class="fi-people" title="users" aria-hidden="true"></span> Manage users</a></dd>
                <dd class="{{ \App\Helpers\ActiveRoute::is_active('admin/roles') }}"><a href="{{ route('admin.roles') }}"><span class="fi-brain" title="roles" aria-hidden="true"></span> Manage roles</a></dd>
                @endif
            </dl>
            @yield('content')
        </div>
    @stop