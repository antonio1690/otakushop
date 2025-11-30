<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario por google_id o email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Si existe, actualizar google_id y avatar
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'role' => 'cliente',
                    'email_verified_at' => now(),
                    'password' => bcrypt(str()->random(16)), // Contraseña aleatoria
                ]);
            }

            Auth::login($user, true);

            return redirect()->route('home')->with('success', '¡Bienvenido ' . $user->name . '! 🎉');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Error al iniciar sesión con Google. Inténtalo de nuevo.');
        }
    }
}