<?php
// app/Helpers/ImageHelper.php
namespace App\Helpers;

class ImageHelper
{
    /**
     * Obtener la URL correcta de una imagen (Cloudinary o local)
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }

        // Si ya es una URL completa (Cloudinary u otra), devolverla directamente
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        // Si es una ruta local, usar asset()
        return asset('storage/' . $imagePath);
    }
}