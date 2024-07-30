<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\CreateSettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Http\Resources\Setting\SettingResource;
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
        return SettingResource::collection($settings);
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
        return SettingResource::make($setting);
    }

    // Update Setting
    public function update(UpdateSettingRequest $request, $id)
    {
        if($request->user()->can('update.setting'))
        {
            $value = $request->value;
            $setting = Setting::find($id)->update(['value'=> $value]);
            return $this->responseService->success_response($setting);
        }
        else
        {
            return  $this->responseService->unauthorized_response();
        }
    }
}
