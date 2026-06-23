<?php

namespace App\Http\Middleware;

use App\Models\ClassModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstructorAssignedToClass
{
    public function handle(Request $request, Closure $next): Response
    {
        $class = $request->route('class');

        if (! $class instanceof ClassModel) {
            return $next($request);
        }

        if ($class->instructor_id !== $request->user()->id) {
            abort(403, __('lms.access.unauthorized'));
        }

        return $next($request);
    }
}
