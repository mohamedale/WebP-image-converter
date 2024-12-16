<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fire-queue', function () {
    $imageData = [
        'path' => public_path('test.png'),
//        'path' => 'https://domain.com/awesome-image.jpeg',
//        'quality' => 80 // Default is 85
    ];
    \App\Jobs\ImageWebpConverter::dispatch($imageData);
});
