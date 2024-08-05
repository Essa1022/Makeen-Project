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
}
