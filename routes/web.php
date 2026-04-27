<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Products/Index');
});
Route::get('/product/{id}', function ($id) {
    return Inertia::render('Products/Show', [
        'id' => $id
    ]);
});