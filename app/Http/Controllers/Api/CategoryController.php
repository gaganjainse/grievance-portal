<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function byDepartment($departmentId)
    {
        return Category::where('department_id', $departmentId)
            ->where('is_active', true)
            ->get(['id', 'name']);
    }
}
