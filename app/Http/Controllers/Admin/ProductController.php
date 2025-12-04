<?php
// app/Http/Controllers/Admin/ProductController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'franchise'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $categories = Category::all();
        $franchises = Franchise::all();

        return view('admin.products.create', compact('categories', 'franchises'));
    }

    /**
     * Almacenar un nuevo recurso en el almacenamiento.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'franchise_id' => 'required|exists:franchises,id',
            'is_preorder' => 'boolean',
            'release_date' => 'nullable|date',
            'featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|url'
        ]);

        // Manejar la subida de imagen a Cloudinary
        if ($request->hasFile('image')) {
            try {
                $uploadedFileUrl = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'otakushop/products',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'fill',
                            'quality' => 'auto',
                            'fetch_format' => 'auto'
                        ]
                    ]
                )->getSecurePath();

                $validated['image'] = $uploadedFileUrl;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Error al subir la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        } elseif ($request->filled('image_url')) {
            // Si se proporciona una URL externa, usarla directamente
            $validated['image'] = $request->image_url;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'franchise']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $franchises = Franchise::all();

        return view('admin.products.edit', compact('product', 'categories', 'franchises'));
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'franchise_id' => 'required|exists:franchises,id',
            'is_preorder' => 'boolean',
            'release_date' => 'nullable|date',
            'featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|url'
        ]);

        // Manejar la subida de imagen a Cloudinary
        if ($request->hasFile('image')) {
            try {
                // Eliminar imagen anterior de Cloudinary si existe
                if ($product->image && str_contains($product->image, 'cloudinary')) {
                    $publicId = $this->getPublicIdFromUrl($product->image);
                    if ($publicId) {
                        Cloudinary::destroy($publicId);
                    }
                }
                // Si la imagen anterior era local, eliminarla también
                elseif ($product->image && !str_contains($product->image, 'http')) {
                    Storage::disk('public')->delete($product->image);
                }

                // Subir nueva imagen a Cloudinary
                $uploadedFileUrl = Cloudinary::upload(
                    $request->file('image')->getRealPath(),
                    [
                        'folder' => 'otakushop/products',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'fill',
                            'quality' => 'auto',
                            'fetch_format' => 'auto'
                        ]
                    ]
                )->getSecurePath();

                $validated['image'] = $uploadedFileUrl;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Error al actualizar la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        } elseif ($request->filled('image_url')) {
            // Si se actualiza con una URL externa
            // Eliminar imagen anterior de Cloudinary si existe
            if ($product->image && str_contains($product->image, 'cloudinary')) {
                $publicId = $this->getPublicIdFromUrl($product->image);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            }
            $validated['image'] = $request->image_url;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy(Product $product)
    {
        // Eliminar imagen de Cloudinary si existe
        if ($product->image && str_contains($product->image, 'cloudinary')) {
            try {
                $publicId = $this->getPublicIdFromUrl($product->image);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            } catch (\Exception $e) {
                // Continuar con la eliminación del producto aunque falle la eliminación de la imagen
            }
        }
        // Si la imagen es local, eliminarla también
        elseif ($product->image && !str_contains($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Extraer el public_id de una URL de Cloudinary.
     */
    private function getPublicIdFromUrl($url)
    {
        // URL ejemplo: https://res.cloudinary.com/cloud_name/image/upload/v1234567890/otakushop/products/filename.jpg
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