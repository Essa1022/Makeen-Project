<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Category index
    public function index(Category $category = null)
    {
        $categories = new Category();
        if($category)
        {
            $categories = $category->categories()->paginate(10);
        }
        else
        {
            $categories = Category::with('categories')->paginate(3);
        }
        return $this->responseService->success_response($categories);
    }
}
