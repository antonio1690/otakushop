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
        $query = Product::with(['category', 'franchise']);

        // Filtrar por categoría
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtrar por franquicia
        if ($request->has('franchise') && $request->franchise) {
            $query->where('franchise_id', $request->franchise);
        }

        // Buscar por nombre
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
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
}
