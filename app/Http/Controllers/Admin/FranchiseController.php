<?php
// app/Http/Controllers/Admin/FranchiseController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FranchiseController extends Controller
{
    public function index()
    {
        $franchises = Franchise::withCount('products')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.franchises.index', compact('franchises'));
    }

    public function create()
    {
        return view('admin.franchises.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:franchises,name',
        'description' => 'nullable|string|max:500',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($request->hasFile('logo')) {
        $uploadedFileUrl = cloudinary()->upload(
            $request->file('logo')->getRealPath(),
            [
                'folder' => 'otakushop/franchises',
                'transformation' => [
                    'width' => 400,
                    'height' => 400,
                    'crop' => 'limit'
                ]
            ]
        )->getSecurePath();
        
        $validated['logo'] = $uploadedFileUrl;
    }

    Franchise::create($validated);

    return redirect()->route('admin.franchises.index')
        ->with('success', 'Franquicia creada exitosamente.');
}


    public function edit(Franchise $franchise)
    {
        return view('admin.franchises.edit', compact('franchise'));
    }

public function update(Request $request, Franchise $franchise)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:franchises,name,' . $franchise->id,
        'description' => 'nullable|string|max:500',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($request->hasFile('logo')) {
        $uploadedFileUrl = cloudinary()->upload(
            $request->file('logo')->getRealPath(),
            [
                'folder' => 'otakushop/franchises',
                'transformation' => [
                    'width' => 400,
                    'height' => 400,
                    'crop' => 'limit'
                ]
            ]
        )->getSecurePath();
        
        $validated['logo'] = $uploadedFileUrl;
    }

    $franchise->update($validated);

    return redirect()->route('admin.franchises.index')
        ->with('success', 'Franquicia actualizada exitosamente.');
}


    public function destroy(Franchise $franchise)
    {
        // Verificar si tiene productos asociados
        if ($franchise->products()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una franquicia con productos asociados.');
        }

        // Eliminar logo si existe
        if ($franchise->logo) {
            Storage::disk('public')->delete($franchise->logo);
        }

        $franchise->delete();

        return redirect()->route('admin.franchises.index')
            ->with('success', 'Franquicia eliminada exitosamente.');
    }
}