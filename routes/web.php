<?php

use App\Http\Controllers\TodoController;
use App\Models\Todo;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', fn() => 'ok')->withoutMiddleware('jwt.auth');

Route::get('/debug', function () {
    /** @var \PHPOpenSourceSaver\JWTAuth\JWTAuth $auth */
    $auth = app('tymon.jwt.auth');

    try {
        $payload = $auth->getPayload();
    } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
        $payload = $e->getMessage();
    }

    return [
        'jwt'     => $payload,
        'server'  => request()->server(),
        'headers' => request()->header(),
        'cookies' => request()->cookie(),
    ];
});

Route::get('/dashboard', function () {
    return view('dashboard', ['todos' => Todo::whereDone(false)->get()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource(
        '/api/todo',
        TodoController::class
    );
});

require __DIR__.'/auth.php';
