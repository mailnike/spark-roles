<?php

namespace App\Http\Middleware;

use Closure;

class HasRoleOnTeam extends AbstractMiddleware
{
    /**
     *  Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $authorizedRoles = array_map('trim', explode('|', $roles));
        $roleOnTeam = $request->user()->roleOn($request->user()->currentTeam);

        if (!in_array($roleOnTeam, $authorizedRoles)) {
            return $this->forbidden($request);
        }

        return $next($request);
    }
}
