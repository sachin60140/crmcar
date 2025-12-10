<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSingleSession
{
    protected $sessionService;
    
    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }
    
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user) {
            $currentSessionId = Session::getId();
            
            // Validate: Does the Browser Session match the Database Session?
            if (!$this->sessionService->validateUserSession($user->id, $currentSessionId)) {
                return $this->forceLogout($request);
            }
        }
        
        return $next($request);
    }
    
    private function forceLogout(Request $request)
    {
        // 1. Clear the LOCAL session (Logout the browser)
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // 2. IMPORTANT: Do NOT set $user->session_id = null; 
        // The database already has the NEW user's ID. If you null it, you kick the new user out too.

        // 3. Handle AJAX Requests (For your auto-redirect script)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Session expired or logged in elsewhere.',
                'redirect' => route('login') // Send the URL so JS can redirect
            ], 401);
        }
        
        // 4. Handle Standard Page Loads
        return redirect()->route('login')
            ->with('error', 'Your account was logged in from another device. Session terminated.');
    }
}