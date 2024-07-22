<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ads\CreateAdsRequest;
use App\Models\Ads;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->can('see.ad'))
        {
            $Ads = Ads::orderby('id','desc')->paginate(10);
            return $this->responseService->success_response($Ads);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    public function show(Request $request, string $id)
    {
            $Ads = Ads::find($id)->with('media');
            return $this->responseService->success_response($Ads);
    }

    public function store(CreateAdsRequest $request)
    {
        if($request->user()->can('create.ad'))
        {
            $input = $request->all();
            if($input['starts_at'] = Carbon::now())
            {
                $input['status'] = true;
            }
            else
            {
                unset($input['status']);
            }
            $Ads = Ads::create($input);
            return $this->responseService->success_response($Ads);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    public function update(CreateAdsRequest $request, string $id)
    {
        $Ads = Ads::find($id);
        $Ads->update($request->toArray());
        return $this->responseService->success_response($Ads);
    }

    public function destroy(Request $request)
    {
        if($request->user()->can('delete.ad'))
        {
            $Ads_ids = $request->input('Ads_ids');
            Ads::destroy($Ads_ids);
            return $this->responseService->delete_response();

        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

}
