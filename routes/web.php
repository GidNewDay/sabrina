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
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});

Route::get('/admin/products', function () {
    return Inertia::render('Admin/Products/Index');
});

Route::get('/admin/products/create', function () {
    return Inertia::render('Admin/Products/Form');
});

Route::get('/admin/products/{id}/edit', function ($id) {
    return Inertia::render('Admin/Products/Form', ['id' => $id]);
});