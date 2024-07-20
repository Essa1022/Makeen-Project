<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\Media\UploadMediaRequest;
use App\Models\Article;
use App\Models\Media;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as ModelsMedia;

class MediaController extends Controller
{

    // Upload Media
    public function upload(UploadMediaRequest $request, $model_type, $model_id)
    {
        if ($request->user()->can('create.media'))
        {
            if ($model_type === 'article')
            {
                $model = Article::find($model_id);
                $model->addMedia($request->file('file'))->toMediaCollection('articles', 'local');
            }
            elseif ($model_type === 'logo')
            {
                $model = Setting::find($model_id);
                $model->addMedia($request->file('file'))->toMediaCollection('logo', 'local');
            }
            elseif ($model_type === 'ad')
            {
                $model = Ads::find($model_id);
                $model->addMedia($request->file('file'))->toMediaCollection('ads', 'local');
            }
            if (!$model)
            {
                return $this->responseService->notFound_response();
            }

            if ($model_type !== 'article' && $model->getMedia()->count() > 1)
            {
                return $this->responseService->error_response('فقط یک عکس می‌توانید آپلود کنید');
            }
            
            return $this->responseService->success_response();
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
            ModelsMedia::destroy($media_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Download Media
    public function download(string $id)
    {
        $media = ModelsMedia::find($id);
        $file = $media->getPath();
        $file_name = $media->file_name;
        return response()->download($file, $file_name);
    }
}
