    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\ProductoController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\UsuarioController;
    use App\Http\Controllers\MovimientoController;
    use Illuminate\Support\Facades\Route;

    // 👥 Solo los administradores podrán acceder a usuarios
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::resource('usuarios', UsuarioController::class);
    // 📦 Productos accesibles para cualquier usuario autenticado
    Route::middleware(['auth'])->group(function () {
        Route::resource('productos', ProductoController::class);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('movimientos', MovimientoController::class)->middleware('auth');
        Route::get('/test-datatables', function () {
    return view('movimientos.test');
});

    });

    // Página de bienvenida (pública)
    Route::get('/', function () {
        return view('welcome');
    });

    require __DIR__ . '/auth.php';
