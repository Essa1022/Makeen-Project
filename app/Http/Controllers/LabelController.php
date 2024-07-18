<?php

namespace App\Http\Controllers;

use App\Http\Requests\Label\CreateLabelRequest;
use App\Http\Requests\Label\UpdateLabelRequest;
use App\Models\Article;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    // Label index
    public function index(Request $request)
    {
        if($request->user()->can('see.label'))
        {
            $labels = Label::all();
            return $this->responseService->success_response($labels);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Store a new Label
    public function store(CreateLabelRequest $request)
    {
        if($request->user()->can('create.label'))
        {
            $label = Label::create($request->toArray());
            return $this->responseService->success_response($label);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Destroy Label
    public function destroy(Request $request)
    {
        if($request->user()->can('delete.label'))
        {
            $label_ids = $request->input('label_ids');
            Label::destroy($label_ids);
            return $this->responseService->delete_response();

        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Sync Label
    public function sync(Request $request, string $id)
    {
        if($request->user()->can('give.label'))
        {
            $label_ids = $request->input('label_ids');
            $article = Article::find($id);
            $article->labels()->sync($label_ids);
            return $this->responseService->success_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}
