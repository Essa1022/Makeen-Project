<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subtitle\CreateSubtitleRequest;
use App\Models\Subtitle;
use Illuminate\Http\Request;

class SubtitleController extends Controller
{
    // Subtitile index
    public function index(Request $request)
    {
        $subtitles = Subtitle::orderBy('id', 'desc')->paginate(10);
        return $this->responseService->success_response($subtitles);
    }

    // Store a new Subtitle
    public function store(CreateSubtitleRequest $request)
    {
        $subtitle = Subtitle::create($request->toArray());
        return $this->responseService->success_response($subtitle);
    }

    // Destroy Subtitle
    public function destroy(Request $request, $id)
    {
        $subtitle_ids = $request->input('subtitle_ids');
        Subtitle::destroy($subtitle_ids);
        return $this->responseService->delete_response();
    }
}
