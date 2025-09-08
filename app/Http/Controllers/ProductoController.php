<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar listado de productos
     */
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Guardar un nuevo producto
     */
public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'codigo' => 'required|string|max:50|unique:productos,codigo',
        'stock'  => 'required|integer|min:0',
        'precio' => 'required|numeric|min:0',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'codigo.required' => 'El código es obligatorio.',
        'codigo.unique'   => 'El código ya existe, ingrese uno diferente.',
        'stock.required'  => 'La cantidad de stock es obligatoria.',
        'stock.integer'   => 'El stock debe ser un número entero.',
        'precio.required' => 'El precio es obligatorio.',
        'precio.numeric'  => 'El precio debe ser un valor numérico.',
    ]);

    Producto::create($request->all());

    return redirect()->route('productos.index')->with('success', '✅Producto creado correctamente.');
}

    /**
     * Mostrar formulario de edición
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualizar producto
     */
   public function update(Request $request, Producto $producto)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
        'stock'  => 'required|integer|min:0',
        'precio' => 'required|numeric|min:0',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'codigo.required' => 'El código es obligatorio.',
        'codigo.unique'   => 'El código ya existe, ingrese uno diferente.',
        'stock.required'  => 'La cantidad de stock es obligatoria.',
        'stock.integer'   => 'El stock debe ser un número entero.',
        'precio.required' => 'El precio es obligatorio.',
        'precio.numeric'  => 'El precio debe ser un valor numérico.',
    ]);

    $producto->update($request->all());

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}

    /**
     * Eliminar producto
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', '🗑️ Producto eliminado correctamente.');
    }
}
