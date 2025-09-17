<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador si no existe
        User::firstOrCreate(
            ['email' => 'admin@inventario.com'], // criterio de búsqueda
            [
                'name' => 'Administrador',
                'role' => 'admin',
                'password' => bcrypt('admin123'),
            ]
        );

        // Crear producto de prueba si no existe
        Producto::firstOrCreate(
            ['codigo' => 'P001'], // criterio de búsqueda
            [
                'nombre' => 'Producto de prueba',
                'cantidad' => 10,
                'precio' => 1000,
                'precio_compra' => 800,
                'precio_venta' => 1200,
                'stock' => 10,
                'min_stock' => 2,
            ]
        );
    }
}