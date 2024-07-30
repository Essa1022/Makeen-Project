<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateMediaRequest;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Http\Requests\Media\UploadMediaRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    // Upload Media
    public function upload(UploadMediaRequest $request, $model_type, $model_id)
    {
        if ($request->user()->can('create.media'))
        {
            $model = null;

            switch ($model_type)
            {
                case 'main_image':
                    $model = Article::find($model_id);
                    if ($request->hasFile('main_image'))
                    {
                        $model->addMedia($request->file('main_image'))->toMediaCollection('main_image', 'local');
                    }
                    break;
                case 'second_image':
                    $model = Article::find($model_id);
                    if ($request->hasFile('second_image'))
                    {
                        $model->addMedia($request->file('second_image'))->toMediaCollection('second_image', 'local');
                    }
                    break;
                case 'logo':
                    $model = Setting::find($model_id);
                    if ($request->hasFile('file'))
                    {
                        $model->addMedia($request->file('file'))->toMediaCollection('logo', 'local');
                    }
                    break;
                case 'ad':
                    $model = Ads::find($model_id);
                    if ($request->hasFile('file'))
                    {
                        $model->addMedia($request->file('file'))->toMediaCollection('ads', 'local');
                    }
            }
            if ($model->getMedia()->count() > 2)
            {
                return $this->responseService->error_response('فقط دو عکس می‌توانید آپلود کنید');
            }
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }


    // Destroy User
    public function destroy(Request $request)
    {
        if($request->user()->can('delete.media'))
        {
            $media_ids = $request->input('media_ids');
            Media::destroy($media_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}
