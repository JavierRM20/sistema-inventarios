<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $stockTotal = Producto::sum('stock');
        $valorTotal = Producto::sum(\DB::raw('stock * precio'));

        return view('dashboard', compact('totalProductos', 'stockTotal', 'valorTotal'));
    }
}
