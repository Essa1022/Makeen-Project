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
    public function show(Request $request, $id)
    {
        $setting = Setting::find($id);
        $media = $setting->media;
        if($media)
        {
            $setting->with('media');
        }
        return $this->responseService->success_response($setting);
    }

    // Store a new Setting
    public function store(CreateSettingRequest $request)
    {
        if($request->user()->can('create.setting'))
        {
            $setting = Setting::create($request->toArray());
            return $this->responseService->success_response($setting);
        }
        else
            {
                return  $this->responseService->unauthorized_response();
            }
    }

    // Update Setting
    public function update(UpdateSettingRequest $request, $id)
    {
        if($request->user()->can('update.setting'))
        {
        $setting = Setting::find($id)->update($request->toArray());
        return $this->responseService->success_response($setting);
        }
        else
        {
            return  $this->responseService->unauthorized_response();
        }
    }

    // Destroy Setting
    public function destroy(Request $request, $id)
    {
        if($request->user()->can('delete.setting'))
        {
            $setting_ids = $request->input('setting_ids');
            $settings = Setting::destroy($setting_ids);
            foreach($settings as $setting)
            {
                foreach($setting->getMedia() as $media)
                {
                    if($media)
                    {
                        $media->delete();
                    }
                }
            }
            return $this->responseService->success_response();
        }
        else
        {
            return  $this->responseService->unauthorized_response();
        }
    }
}
