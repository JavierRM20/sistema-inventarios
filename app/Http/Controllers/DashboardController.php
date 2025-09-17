<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();

        // Sumatoria de todas las unidades en stock
        $stockTotal = Producto::sum('cantidad');

        // Valor acumulado del inventario según precio de compra
        $valorCompra = Producto::sum(DB::raw('cantidad * precio_compra'));

        // Valor acumulado del inventario según precio de venta
        $valorVenta = Producto::sum(DB::raw('cantidad * precio_venta'));

        return view('dashboard', compact(
            'totalProductos',
            'stockTotal',
            'valorCompra',
            'valorVenta'
        ));
    }
}