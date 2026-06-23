<?php

namespace App\Http\Middleware;

use App\Models\ClassModel;
use App\Models\ClassParticipant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePesertaEnrolledInClass
{
    public function handle(Request $request, Closure $next): Response
    {
        $class = $request->route('class');

        if (!$class instanceof ClassModel) {
            return $next($request);
        }

        $isEnrolled = ClassParticipant::where('class_id', $class->id)
            ->where('participant_id', $request->user()->id)
            ->where('status', 'active')
            ->exists();

        if (!$isEnrolled) {
            abort(403, __('lms.access.not_enrolled'));
        }

        return $next($request);
    }
}
