<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SessionService
{
    public function validateUserSession($userId, $currentSessionId)
    {
        $user = User::find($userId);
        
        if (!$user || !$user->session_id) {
            return true;
        }
        
        // Check if session exists in sessions table
        if (config('session.driver') === 'database') {
            $sessionExists = DB::table('sessions')
                ->where('id', $user->session_id)
                ->where('user_id', $userId)
                ->exists();
                
            if (!$sessionExists) {
                // Session expired, clear it
                $user->session_id = null;
                $user->save();
                return true;
            }
        }
        
        return $user->session_id === $currentSessionId;
    }
    
    public function logoutFromAllDevices($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->session_id = null;
            $user->save();
            
            // Clear from sessions table
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', $userId)
                    ->delete();
            }
        }
    }
}