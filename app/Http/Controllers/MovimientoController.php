<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index()
    {
        $movimientos = Movimiento::with(['producto', 'user'])->latest()->paginate(10);
        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('movimientos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo'        => 'required|in:entrada,salida',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // Verificar stock si es salida
        if ($request->tipo === 'salida' && $producto->cantidad < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente para realizar la salida.']);
        }

        // Actualizar stock
        if ($request->tipo === 'entrada') {
            $producto->cantidad += $request->cantidad;
        } else {
            $producto->cantidad -= $request->cantidad;
        }
        $producto->save();

        // Registrar el movimiento (solo una vez ✅)
        Movimiento::create([
            'producto_id'   => $producto->id,
            'tipo'          => $request->tipo,
            'cantidad'      => $request->cantidad,
            'referencia'    => $request->referencia,
            'observaciones' => $request->observaciones,
            'user_id'       => auth()->id(),
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
    }
}
