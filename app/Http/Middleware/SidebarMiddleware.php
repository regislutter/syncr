<?php

namespace App\Http\Middleware;

use App\Client;
use App\Project;
use Closure;

class SidebarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $clients = Client::where('archived', 0)->orderBy('name')->get();
        $projects = Project::whereIn('client_id', $clients->lists('id'))->where('archived', 0)->orderBy('name')->get();

        session(['projects' => $projects, 'clients' => $clients]);
        return $next($request);
    }
}
