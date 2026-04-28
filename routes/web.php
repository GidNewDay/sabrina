<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Products/Index', [
        // пробрасываем query параметр в props
        'category_id' => request('category_id')
    ]);
});
Route::get('/product/{id}', function ($id) {
    return Inertia::render('Products/Show', [
        'id' => $id
    ]);
});