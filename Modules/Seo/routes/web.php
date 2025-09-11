<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Controllers\SeoMetaController;

Route::prefix('seo')->controller(SeoMetaController::class)->group(function () {
    Route::get('/edit', [SeoMetaController::class, 'edit'])->name('seo.edit');
    Route::post('/update', [SeoMetaController::class, 'update'])->name('seo.update');
});
