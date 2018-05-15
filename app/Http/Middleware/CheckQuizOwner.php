<?php

namespace App\Http\Middleware;

use App\Quiz;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckQuizOwner
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

        $quiz = Quiz::findOrFail($request->quizId);
        if ($quiz->user_id  !== Auth::id()){
            return redirect('home');
        }
        return $next($request);
    }
}
