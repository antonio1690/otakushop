<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Perfil actualizado correctamente.');
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

        try {
            // Eliminar avatar anterior de Cloudinary si existe
            if ($user->avatar && str_contains($user->avatar, 'cloudinary')) {
                $publicId = $this->getPublicIdFromUrl($user->avatar);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            }
            // Si el avatar anterior era local, eliminarlo también
            elseif ($user->avatar && !str_contains($user->avatar, 'googleusercontent') && !str_contains($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Subir nuevo avatar a Cloudinary
            $uploadedFileUrl = Cloudinary::upload(
                $request->file('avatar')->getRealPath(),
                [
                    'folder' => 'otakushop/avatars',
                    'transformation' => [
                        'width' => 400,
                        'height' => 400,
                        'crop' => 'fill',
                        'gravity' => 'face',
                        'quality' => 'auto',
                        'fetch_format' => 'auto'
                    ]
                ]
            )->getSecurePath();

            // Guardar URL de Cloudinary en la base de datos
            $user->avatar = $uploadedFileUrl;
            $user->save();

            return Redirect::route('profile.edit')->with('success', 'Avatar actualizado correctamente.');

        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Error al subir el avatar: ' . $e->getMessage());
        }
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

        // Eliminar avatar de Cloudinary antes de eliminar el usuario
        if ($user->avatar && str_contains($user->avatar, 'cloudinary')) {
            try {
                $publicId = $this->getPublicIdFromUrl($user->avatar);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            } catch (\Exception $e) {
                // Continuar aunque falle la eliminación de la imagen
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Cuenta eliminada correctamente.');
    }

    /**
     * Extraer el public_id de una URL de Cloudinary.
     */
    private function getPublicIdFromUrl($url)
    {
        // URL ejemplo: https://res.cloudinary.com/cloud_name/image/upload/v1234567890/otakushop/avatars/filename.jpg
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        
        // Encontrar el índice de 'upload'
        $uploadIndex = array_search('upload', $parts);
        
        if ($uploadIndex === false) {
            return null;
        }
        
        // Todo después de 'upload' y el version number es el public_id
        $publicIdParts = array_slice($parts, $uploadIndex + 2); // +2 para saltar 'upload' y 'v1234567890'
        $publicIdWithExtension = implode('/', $publicIdParts);
        
        // Quitar la extensión
        return pathinfo($publicIdWithExtension, PATHINFO_DIRNAME) . '/' . pathinfo($publicIdWithExtension, PATHINFO_FILENAME);
    }
}