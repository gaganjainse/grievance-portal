<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

Route::get('/categories/{departmentId}', [CategoryController::class, 'byDepartment']);
