<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ads\CreateAdsRequest;
use App\Http\Requests\Ads\UpdateAdsRequest;
use App\Http\Requests\Media\UploadMediaRequest;
use App\Http\Resources\Ad\AdResource;
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
            return AdResource::collection($Ads);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

<<<<<<< HEAD
    public function show(string $id)
=======
    public function show(Request $request)
>>>>>>> 3e8cc3ae77793368004669258f88680580dc7666
    {
            $Ad = Ads::where('ad_place', $request->ad_place)
                ->where('status', true)
                ->first();
            return AdResource::make($Ad);
    }

    public function store(CreateAdsRequest $request)
    {
        if($request->user()->can('create.ad'))
        {
            $input = $request->all();
<<<<<<< HEAD
            if(!$input['starts_at'] = Carbon::now())
=======
            if($input['starts_at'] = Carbon::today())
            {
                $input['status'] = true;
            }
            else
>>>>>>> 3e8cc3ae77793368004669258f88680580dc7666
            {
                unset($input['status']);
            }

            $Ads = Ads::create($input);

            $mediaRequest = UploadMediaRequest::createFromBase($request);
            $mediaRequest->setUserResolver(function () use ($request) {
                return $request->user();
            });
            app(MediaController::class)->upload($mediaRequest, 'ad', $Ads->id);
            $Ads->load('media');
            return $this->responseService->success_response($Ads);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    public function update(UpdateAdsRequest $request, string $id)
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
