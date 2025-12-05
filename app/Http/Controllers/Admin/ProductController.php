<?php
// app/Http/Controllers/Admin/ProductController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


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

        // Manejar la subida de imagen con optimización
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = public_path('storage/products/' . $filename);
        
            // Crear directorio si no existe
            if (!file_exists(public_path('storage/products'))) {
                mkdir(public_path('storage/products'), 0777, true);
            }
        
            // Redimensionar y optimizar imagen
            Image::read($image)
                ->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path, 85); // 85% de calidad        
            $validated['image'] = 'products/' . $filename;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Manejar la subida de imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
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
        // Eliminar imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}