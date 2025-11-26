<?php
// app/Http/Controllers/Admin/OrderController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filtrar por estado
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Buscar por ID o nombre de usuario
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pendiente,procesando,enviado,entregado,cancelado'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function destroy(Order $order)
    {
        // Solo permitir eliminar pedidos cancelados
        if ($order->status !== 'cancelado') {
            return back()->with('error', 'Solo se pueden eliminar pedidos cancelados.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}