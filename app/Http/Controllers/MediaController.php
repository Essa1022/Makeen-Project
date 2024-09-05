<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Media\UploadMediaRequest;
use App\Models\Setting;
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
                        $model->addMedia($request->file('main_image'))->toMediaCollection('main_image', 'public');
                    }
                    break;
                case 'second_image':
                    $model = Article::find($model_id);
                    if ($request->hasFile('second_image'))
                    {
                        $model->addMedia($request->file('second_image'))->toMediaCollection('second_image', 'public');
                    }
                    break;
                case 'logo':
                    $model = Setting::find($model_id);
                    if ($request->hasFile('logo'))
                    {
                        $model->addMedia($request->file('logo'))->toMediaCollection('logo', 'public');
                    }
                    break;
                case 'ad':
                    $model = Ads::find($model_id);
                    if ($request->hasFile('ad_image'))
                    {
                        $model->addMedia($request->file('ad_image'))->toMediaCollection('ads', 'public');
                    }
                case 'avatar':
                    $model = User::find($model_id);
                    if ($request->hasFile('profile_image'))
                    {
                        $model->addMedia($request->file('profile_image'))->toMediaCollection('avatar', 'public');
                    }
                    break;
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
