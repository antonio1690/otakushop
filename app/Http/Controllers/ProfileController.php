<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de perfil del usuario.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Obtener estadísticas del usuario
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->sum('total');
        $pendingOrders = $user->orders()->where('status', 'pendiente')->count();
        $completedOrders = $user->orders()->where('status', 'entregado')->count();
        
        // Últimos pedidos
        $recentOrders = $user->orders()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('profile.edit', compact(
            'user',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'completedOrders',
            'recentOrders'
        ));
    }

    /**
     * Actualizar la información del perfil del usuario.
     */
public function update(Request $request): RedirectResponse
{
    $user = $request->user();
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Subida del avatar a Cloudinary
    if ($request->hasFile('avatar')) {
        $uploadedFileUrl = cloudinary()->upload(
            $request->file('avatar')->getRealPath(),
            [
                'folder' => 'otakushop/avatars',
                'transformation' => [
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'fill',
                    'gravity' => 'face'
                ]
            ]
        )->getSecurePath();

        $validated['avatar'] = $uploadedFileUrl;
    }

    $user->update($validated);

    return back()->with('success', 'Perfil actualizado correctamente.');
}


    /**
     * Actualizar el avatar del usuario.
     */
public function updateAvatar(Request $request): RedirectResponse
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $user = $request->user();

    // Subida del avatar a Cloudinary
    $uploadedFileUrl = cloudinary()->upload(
        $request->file('avatar')->getRealPath(),
        [
            'folder' => 'otakushop/avatars',
            'transformation' => [
                'width' => 300,
                'height' => 300,
                'crop' => 'fill',
                'gravity' => 'face'
            ]
        ]
    )->getSecurePath();

    $user->avatar = $uploadedFileUrl;
    $user->save();

    return Redirect::route('profile.edit')->with('success', 'Avatar actualizado correctamente.');
}


    /**
     * Eliminar la cuenta del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Cuenta eliminada correctamente.');
    }
}