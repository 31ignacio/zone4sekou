<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AutoLogout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $timezone = 'Europe/Paris'; // GMT+1
            $now = Carbon::now($timezone);

           // Définir l'heure de début (5h) et de fin (10h) dans le fuseau horaire GMT+1
            $start_time = Carbon::today($timezone)->setHour(07);
            $end_time = Carbon::today($timezone)->setHour(10);
            //dd($now,$start_time,$end_time );

            // Vérifiez si l'utilisateur a le rôle "caisse" ou "superviseur"
            if ($user->role_id == 2 ) { // Supposons que 1 correspond au rôle "caisse" et 2 correspond au rôle "superviseur"
                // Si l'heure actuelle est entre 10h et 6h, déconnectez l'utilisateur
                if ($now->between($start_time, $end_time)) {
                    Auth::logout();
                    // return redirect()->route('login')->with('error_msg', 'Vous avez été déconnecté automatiquement. Vous pourrez vous reconnecter à 10h.');
                    return redirect()->route('login')->with('error_msg', 'Vous avez été déconnecté automatiquement.');
                }
            }
        }

        return $next($request);
    }
}
