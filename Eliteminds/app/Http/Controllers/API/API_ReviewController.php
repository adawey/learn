<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\Review\ReviewCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class API_ReviewController extends Controller
{
    public function reviewByPackage(Request $req){
        $reviews = \App\Rating::where('package_id', $req->package_id)->orderBy('created_at', 'desc')->paginate($req->per_page);
        return ReviewCollection::collection($reviews);
    }

    public function overallPackageReview(Request $request){
        $reviews = $this->getPackageReviews($request->package_id);
        $rating = [];
        for($i=1; $i<6; $i++){
            array_push($rating, [
                'rate'          => $i,
                'totalRates'    => $reviews->filter(function($row)use($i){return $row->rate == $i;})->count()/$reviews->count() * 100
            ]);
        }

        return response()->json($rating, 200);
    }

    private function getPackageReviews($package_id){
        return \App\Rating::where('package_id', $package_id)->get();
    }
    
    public function push_review(Request $req){
        /**
         * package_id
         * rate (1 -> 5)
         * description
         */

        $package = \App\Packages::find($req->package_id);
        if(!$package){
            return response()->json(null, 404);
        }

        if(!($req->rate <= 5 && $req->rate >= 1)){
            return response()->json(null, 500);
        }
        
        $rate = new \App\Rating;
        $rate->package_id = $req->package_id;
        $rate->user_id = Auth::user()->id;
        $rate->rate = $req->rate;
        $rate->review = $req->description ? $req->description: null;
        $rate->save();

        return response()->json($rate, 201);

    }
}
