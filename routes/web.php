<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('password.request');

Route::get('/admin/users', function () {
    return view('admin.users');
})->name('admin.users');

Route::get('/admin/anggota', function () {
    return view('admin.anggota');
})->name('admin.anggota');

Route::get('/admin/materi', function () {
    return view('admin.materi');
})->name('admin.materi');

Route::get('/admin/hasilkarya', function () {
    return view('admin.hasilkarya');
})->name('admin.hasilkarya');

Route::get('/admin/artikel', function () {
    return view('admin.artikel');
})->name('admin.artikel');

Route::get('/author/artikel', function () {
    return view('author.artikel');
})->name('author.artikel');

Route::get('/editor/artikel', function () {
    return view('editor.artikel'); 
})->name('editor.artikel');
