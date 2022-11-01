<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class API_GeneralController extends Controller
{
    /**
     * return about us text
     * @return \Illuminate\Http\JsonResponse
     */
    public function about(){
        /** Can be pulled from DB later */
        return response()->json([
            'about' => env('APP_NAME').' is one of the world’s leading certification training providers. We partner with companies and individuals to address their unique needs, providing training and coaching that helps working professionals achieve their career goals.I am developing this Blog to help as my way of giving back to the Project Management Community and to the professionals who want to become a PMP, PMI-RMP, and PMI-SP. In this blog you can find all necessary study material relevant to the Project Management Professional (PMP), Risk Management Professional(PMI-RMP) and Scheduling Professional (PMI-SP) certification exam preparation. I hope that these study materials and notes are thorough enough for you to take and run with. With that said, please bear in mind that I am a human, and even though I am taking the utmost care to give you correct and accurate information, forgive me for any inaccuracy. I would appreciate if you notify me so I can correct any information, and tell me what I should do to improve this blog to help the project management community at large. I hope you enjoy visiting my site and find it useful for your studies and for further knowledge advancement. Thank you., PMP, PMI-RMP, PMI-SP '.env('OWNER_EMAIL'),
        ], 200);
    }

    /**
     * Store to DB contact-us form responses
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactUs(Request $request){
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required',
            'message'   => 'required',
        ]);

        $res_id = DB::table('contact_us_responses')
            ->insertGetId(
                $request->merge([
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ])
                ->only(['name', 'email', 'message', 'created_at', 'updated_at'])
            );

        return response()->json(['response_id' => $res_id], 201);
    }


    public function domains(){
        return collect(DB::table('process_groups')
            ->get(['id', 'name']));
    }

    public function courses(){
        return collect(DB::table('courses')
            ->where('private', '=', 0)
            ->select('id', DB::raw('(title) AS name'))
            ->get()
        );
    }

    public function chapters($course_id){
        return collect(DB::table('chapters')
            ->where('course_id', $course_id)
            ->get(['id', 'name']));
    }

}
