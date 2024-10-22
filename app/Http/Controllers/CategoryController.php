<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Category index
    public function index(Request $request, Category $category = null)
    {
        $categories = new Category();

        if($request->main_category)
        {
            $categories = $categories->where('category_id', null)->paginate(10);
        }
        elseif($category)
        {
            $categories = $category->categories()->paginate(10);
        }
        else
        {
            $categories = Category::with('categories')->paginate(3);
        }

        return $this->responseService->success_response($categories);
    }

    // Store a new Category
    public function store(CategoryRequest $request)
    {
        if ($request->user()->can('create.category'))
        {
            $category = Category::create($request->toArray());
            return $this->responseService->success_response($category);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Update Category
    public  function update(CategoryRequest $request, string $id)
    {
        if ($request->user()->can('update.category'))
        {
            $category = Category::find($id);
            $category->update($request->toArray());
            return $this->responseService->success_response($category);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Destroy Category
    public function destroy(Request $request)
    {
        if ($request->user()->can('delete.category'))
        {
            $category_ids = $request->input('category_ids');
            Category::destroy($category_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}
