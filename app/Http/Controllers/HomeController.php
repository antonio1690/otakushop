<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Franchise;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)
            ->with(['category', 'franchise'])
            ->take(8)
            ->get();
        
        $categories = Category::all();
        $franchises = Franchise::all();
        
        return view('home', compact('featuredProducts', 'categories', 'franchises'));
    }

    public function catalog(Request $request)
    {
        $products = $this->searchProducts($request);
        $categories = Category::all();
        $franchises = Franchise::all();

        return view('catalog', compact('products', 'categories', 'franchises'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'franchise']);
        $relatedProducts = Product::where('franchise_id', $product->franchise_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function searchProducts(Request $request)
    {
        $query = Product::with(['category', 'franchise']);

        // Filtrar por búsqueda
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrar por categoría
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtrar por franquicia
        if ($request->has('franchise') && $request->franchise) {
            $query->where('franchise_id', $request->franchise);
        }

        // Filtrar por rango de precio
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filtrar por disponibilidad
        if ($request->has('availability')) {
            switch ($request->availability) {
                case 'in_stock':
                    $query->where('stock', '>', 0)->where('is_preorder', false);
                break;
                case 'preorder':
                    $query->where('is_preorder', true);
                break;
                case 'out_of_stock':
                    $query->where('stock', 0)->where('is_preorder', false);
                break;
            }
        }

        // Ordenar
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
    
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
            break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
            break;
            case 'name':
                $query->orderBy('name', 'asc');
            break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Si es una petición AJAX, devolver JSON
        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                ]
            ]);
        }

        return $products;
    }
}
