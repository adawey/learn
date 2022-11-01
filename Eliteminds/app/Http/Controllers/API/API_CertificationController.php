<?php


namespace App\Http\Controllers\API;


use App\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class API_CertificationController
{
    public function create(Request $request){
        if(!$this->secure($request->product_type, $request->product_id)){
            return response()->json(null, 403);
        }

        $cert = Certification::where('user_id', Auth::user()->id)
            ->where(function($query)use($request){
                if($request->product_type == 'package'){
                    $query->where('package_id', $request->product_id);
                }elseif($request->product_type == 'event'){
                    $query->where('event_id', $request->product_id);
                }
            })
            ->first();

        if($cert){
            return response()->json(['certification_link'   => $this->sendCertification($cert->id)], 200);
        }

        // get image path
        $img_path = 'public/certifications/cert3.jpg';

        // pass it to certification1 function
        $certificationModule = app('App\Http\Controllers\CertificationController');
        $cert_id = $certificationModule->certification1($request->name, $request->product_type, $request->product_id, $img_path);

        return response()->json(['certification_link'   => $this->sendCertification($cert_id)], 200);
    }

    private function secure($product_type, $product_id){
        if($product_type == 'package'){
            $package = DB::table('user_packages')
                ->where('user_packages.package_id', $product_id)
                ->where('user_packages.user_id', Auth::user()->id)
                ->join('packages', 'user_packages.package_id', '=', 'packages.id')
                ->first();
            if(!$package){
                return false;
                if($package->certification == 0){
                    return false;
                }
            }
        }elseif($product_type == 'event'){
            $event = DB::table('event_user')
                ->where([
                    'event_id'  => $product_id,
                    'user_id'   => Auth::user()->id
                ])
                ->join('events', 'event_user.event_id', '=', 'events.id')
                ->first();
            if(!$event){
                return false;
                if($event->certification == 0){
                    return false;
                }
            }
        }
        return true;
    }

    private function sendCertification($id){
        $path = 'public/userCertifications/';
        $c = \App\Certification::find($id);
        if(!$c){
            return false;
        }
        $path .= Auth::user()->id.$c->c_num.'.jpg';
        if(!Storage::exists($path)){
            return false;
        }
        return url('storage/userCertifications/'.Auth::user()->id.$c->c_num.'.jpg');
    }

    public function index(){
        $certifications = DB::table('certifications')
            ->where('user_id', Auth::user()->id)
            ->select(
                DB::raw('(CASE WHEN certifications.package_id IS NULL THEN \'event\' ELSE \'package\' END) AS product_type'),
                DB::raw('(CASE WHEN certifications.package_id IS NULL THEN certifications.event_id ELSE certifications.package_id END) AS product_id'),
                'created_at',
                'c_num'
            )
            ->get()->map(function($row){
                return (object)[
                    'product_type'          => $row->product_type,
                    'product_id'            => $row->product_id,
                    'certification_link'    => url('storage/userCertifications/'.Auth::user()->id.$row->c_num.'.jpg'),
                    'created_at'            => $row->created_at
                ];
            })->toArray();
        return response()->json($certifications, 200);
    }
}
