<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar listado de productos
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Filtro de búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('codigo', 'like', '%' . $request->search . '%');
        }

        // Paginación de 10 productos
        $productos = $query->orderBy('id', 'desc')->get();

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
            'nombre'        => 'required|string|max:255',
            'codigo'        => 'required|string|max:50|unique:productos,codigo',
            'cantidad'      => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta'  => 'required|numeric|min:0',
            'min_stock'     => 'required|integer|min:0',    
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'codigo.required'   => 'El código es obligatorio.',
            'codigo.unique'     => 'El código ya existe, ingrese uno diferente.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer'  => 'La cantidad debe ser un número entero.',
            'precio.required'   => 'El precio es obligatorio.',
            'precio.numeric'    => 'El precio debe ser un valor numérico.',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', '✅ Producto creado correctamente.');
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
            'nombre'        => 'required|string|max:255',
            'codigo'        => 'required|string|max:50|unique:productos,codigo,' . ($producto->id ?? ''),
            'cantidad'      => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta'  => 'required|numeric|min:0',
            'min_stock'     => 'required|integer|min:0',    
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'codigo.required'   => 'El código es obligatorio.',
            'codigo.unique'     => 'El código ya existe, ingrese uno diferente.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer'  => 'La cantidad debe ser un número entero.',
            'precio.required'   => 'El precio es obligatorio.',
            'precio.numeric'    => 'El precio debe ser un valor numérico.',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', '✅ Producto actualizado correctamente.');
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
