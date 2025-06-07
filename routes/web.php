<?php

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

// --- TEMPORARY ROUTES FOR DEPLOYMENT ---
// Visit /run-migrations to run migrations and seeders (then remove this route for security)
Route::get('/run-migrations', function () {
    \Artisan::call('migrate', ["--force" => true]);
    \Artisan::call('db:seed', ["--force" => true]);
    return 'Migrations and seeders have been run! REMOVE THIS ROUTE after use!';
});
// Visit /generate-key to generate a new app key (then remove this route for security)
Route::get('/generate-key', function () {
    \Artisan::call('key:generate', ["--force" => true]);
    return 'Key generated: ' . env('APP_KEY') . ' REMOVE THIS ROUTE after use!';
});
// Visit /show-log to view the latest Laravel log (then remove this route for security)
Route::get('/show-log', function () {
    return nl2br(file_get_contents(storage_path('logs/laravel.log')));
});
// --- END TEMPORARY ROUTES ---
