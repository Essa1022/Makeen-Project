<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\CreateSettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    // Setting index
    public function index(Request $request)
    {
        if($request->user()->can('see.setting'))
        {
        $settings = Setting::all();
        return $this->responseService->success_response($settings);
        }
        else
        {
            return  $this->responseService->unauthorized_response();
        }
    }

    // Show specific Setting
    public function show(string $id)
    {
        $setting = Setting::find($id);
        $media = $setting->media;
        if($media)
        {
            $setting->with('media');
        }
        return $this->responseService->success_response($setting);
    }

    // Update Setting
    public function update(UpdateSettingRequest $request, $id)
    {
        if($request->user()->can('update.setting'))
        {
            $value = $request->value;
            $setting = Setting::find($id)->update(['value'=> $value]);
            if($setting->hasFile('logo'))
            {
                $media = $setting->media;
                $media->delete();
                $setting->addMedia($request->file('logo'))->toMeddiaCollection('logo');
            }

            return $this->responseService->success_response($setting);
        }
        else
        {
            return  $this->responseService->unauthorized_response();
        }
    }
}
