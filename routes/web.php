<?php
// utility
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

// model
use App\Models\User;

// controller
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LoginController;

// Address
use App\Http\Controllers\Admin\Address\ProvinceController;
use App\Http\Controllers\Admin\Address\RegencieController;
use App\Http\Controllers\Admin\Address\DistrictController;
use App\Http\Controllers\Admin\Address\VillageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// home default
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('auth.login');
});

// auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'check_login'])->name('login.check_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

// home
Route::get('/home', function () {
    $user = Auth::user();
    $role = isset($user->role) ? $user->role : null;
    switch ($role) {
        case User::ROLE_ADMIN:
            return Redirect::route('admin.dashboard');
            break;

        default:
            return '';
            break;
    }
})->name('dashboard');

// user management all route
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified', 'admin']], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', ['page_attr' => ['title' => 'Dashboard']]);
    })->name('admin.dashboard');

    // user
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
        Route::delete('/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::post('/update', [UserController::class, 'update'])->name('admin.user.update');
    });

    // address
    Route::group(['prefix' => 'address'], function () {

        // Province
        Route::group(['prefix' => 'province'], function () {
            Route::get('/', [ProvinceController::class, 'index'])->name('admin.address.province');
            Route::get('/select2', [ProvinceController::class, 'select2'])->name('admin.address.province.select2');
            Route::post('/', [ProvinceController::class, 'store'])->name('admin.address.province.store');
            Route::delete('/{id}', [ProvinceController::class, 'delete'])->name('admin.address.province.delete');
            Route::post('/update', [ProvinceController::class, 'update'])->name('admin.address.province.update');
        });

        // Regencie
        Route::group(['prefix' => 'regencie'], function () {
            Route::get('/', [RegencieController::class, 'index'])->name('admin.address.regencie');
            Route::post('/', [RegencieController::class, 'store'])->name('admin.address.regencie.store');
            Route::delete('/{id}', [RegencieController::class, 'delete'])->name('admin.address.regencie.delete');
            Route::post('/update', [RegencieController::class, 'update'])->name('admin.address.regencie.update');
        });

        // District
        Route::group(['prefix' => 'district'], function () {
            Route::get('/', [DistrictController::class, 'index'])->name('admin.address.district');
            Route::post('/', [DistrictController::class, 'store'])->name('admin.address.district.store');
            Route::delete('/{id}', [DistrictController::class, 'delete'])->name('admin.address.district.delete');
            Route::post('/update', [DistrictController::class, 'update'])->name('admin.address.district.update');
        });

        // Village
        Route::group(['prefix' => 'village'], function () {
            Route::get('/', [VillageController::class, 'index'])->name('admin.address.village');
            Route::post('/', [VillageController::class, 'store'])->name('admin.address.village.store');
            Route::delete('/{id}', [VillageController::class, 'delete'])->name('admin.address.village.delete');
            Route::post('/update', [VillageController::class, 'update'])->name('admin.address.village.update');
        });
    });
});


Route::get('/tesadmin', function () {
    return view('templates.admin.index');
});


Route::get('db', function () {
});
