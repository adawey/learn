<?php

namespace App\Http\Controllers;

use App\Localization\Locale;
use App\Repository\PackageRepositoryInterface;
use App\Transcode\Transcode;
use App\Zone\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Chapters;
use App\Process_group;
use App\Packages;
use App\QuestionRoles;
use App\Question;
use App\UserPackages;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class packageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin')->except(['packageByCourse']); //default auth --->> auth:web
    }
    
    /**
     * @param string $title
     * @param int $package_id
     */
    public function doSlug(string $title, int $package_id): void
    {
        $slug = $this->makeSlug($title, '-');
        $slugExists = DB::table('packages')
            ->where('slug', $slug)
            ->exists();
        if($slugExists){
            $slug = $slug.'-'.$package_id;
            $slugExists = DB::table('packages')->where('slug', $slug)->exists();
            while($slugExists){
                $slug = $slug.'-'.mt_rand(1000, 9999);
            }
        }

        DB::table('packages')->where('id', $package_id)->update(['slug' => $slug]);
    }

    /**
     * @param $str
     * @param string $delimiter
     * @return string
     */
    public function makeSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Packages::all();
        return view('packages/index')->with('packages', $packages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapters = Chapters::all();
        $process = Process_group::all();
        return view('packages/add-form')->with('chapters', $chapters)->with('process', $process);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
               
        if($request->input('chapter') == 'on'){

            $chapter_inc = [];
            $process_group_inc=[];
            /* Test for Check box input (Chapters) */
            $chapters = Chapters::all();
            $chapters_included = [];
            foreach($chapters as $ch){
                if($request->has('c'.$ch->id)){
                    $chapters_included[$ch->id] = $ch->name;
                    array_push($chapter_inc, $ch->id);
                }
            }

            /* Test for check box input (Proccess Groups) */
            $process_group = Process_group::all();
            $process_group_included = [];
            foreach ($process_group as $pg) {
                if($request->has('p'.$pg->id)){
                    $process_group_included[$pg->id] = $pg->name;
                    array_push($process_group_inc, $pg->id);
                }
            }    

            if( empty($chapters_included) && empty($process_group_included))
                return back()->withErrors(['You haven\'t Select any Chapter or Process Group !'])->withInput();
        }


        if($request->input('exam') == 'on'){
            $exams_arr = $request->input('exams');
            $exams_str = implode(',',$exams_arr);
        }
        
        

        /* Validation */
        $this->validate($request,[
            'name' => 'required',
//            'name_ar' => 'required',
            'price' => 'numeric|required',
            'discount' => 'numeric|required',
            'expire'    => 'numeric|required',
            'extension_in_days' => 'numeric|required',
            'extension_price' => 'numeric|required',
            'max_extension' => 'numeric|required',
            'description' => 'required',
//            'filter' => 'required',
            'contant_type' => 'required',
            'img' => 'required|mimes:png,jpg,jpeg', // 100 MB
            'img_large' => 'mimes:png,jpg,jpeg', // 100 MB
            'img_small' => 'required|mimes:png,jpg,jpeg', // 100 MB
            'preview_video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
            'what_you_learn'=>'required',
            'requirement'=>'required',
//            'who_course_for'=>'required',
//            'what_you_learn_ar'=>'required',
//            'requirement_ar'=>'required',
//            'who_course_for_ar'=>'required',
//            'description_ar' => 'required',
            'enroll_msg'=>'required',
            'lang' => 'required',
            'course_id' => 'required',
            'certification'=>'numeric|required',
        ]);

        $packages_with_the_same_name = Packages::where('name', '=', $request->input('name'));
        if($packages_with_the_same_name->get()->first()){
            return back()->withErrors(['Please Choose Another name !'])->withInput();
        }

        if($request->input('chapter') ==''&& $request->input('exam') == ''){
            return back()->withErrors(['You haven\'t Select Package includes !'])->withInput();
        }

        if($request->input('discount') > 100){
            return back()->withErrors(['discount can not be greater than 100% !'])->withInput();
        }

        if($request->input('max_extension') != 0 && $request->input('extension_in_days') != 0){


            if($request->input('max_extension') % $request->input('extension_in_days') != 0){
                return back()->withErrors(['max number of extension days must be divisible by extend days !'])->withInput();
            }
        }


        /**
        *    Calculate the price after discount
        */
        $price = $this->price_after_discount($request->input('price'), $request->input('discount'));

        /** 
         * it's time to store data
         */
        // frist store the package info at package table
        $new_package = new Packages;
        $new_package->name = $request->input('name');
        $new_package->original_price = $request->input('price');
        $new_package->price = $price;
        $new_package->expire_in_days = $request->input('expire');
        $new_package->extension_in_days = $request->input('extension_in_days');
        $new_package->max_extension_in_days = $request->input('max_extension');
        $new_package->extension_price = $request->input('extension_price');
        $new_package->discount = $request->input('discount');
        $new_package->description = $request->input('description');
        $new_package->course_id = $request->input('course_id');
        $new_package->lang = $request->input('lang');
        $new_package->requirement = $request->input('requirement');
        $new_package->what_you_learn = $request->input('what_you_learn');
        $new_package->who_course_for = $request->input('who_course_for');
        $new_package->enroll_msg = $request->input('enroll_msg');
        $new_package->img = $request->file('img')->store('public/package/imgs/');
        $new_package->img_large = $request->file('img_large')->store('public/package/imgs/');
        $new_package->img_small = $request->file('img_small')->store('public/package/imgs/');
        if($request->hasFile('preview_video')){
            $new_package->preview_video_url = $request->file('preview_video')->store('public/package/preview/');
        }

        $new_package->certification = $request->input('certification');
        if($request->input('certification')){
            $new_package->certification_title = $request->input('certification_title');
            $new_package->total_time = $request->course_hours;
        }


        $new_package->active = 1;
        $new_package->popular = 1;

        if($request->input('chapter') != ''){
            $new_package->chapter_included = implode(",", $chapter_inc);
            $new_package->process_group_included= implode(",", $process_group_inc);
        }
        if($request->input('exams') != ''){
            $new_package->exams = $exams_str;
        }
        $new_package->filter = 'all';
        $new_package->contant_type = $request->input('contant_type');
        $new_package->save();


        /**
         * Store Prices
         */
        $zones = DB::table('zones')->get();
        foreach($zones as $zone){
            if($request->has('price_zone_'.$zone->id) && $request->input('price_zone_'.$zone->id) != ''){

                $original_price = $request->input('price_zone_'.$zone->id);
                $discount = $request->input('discount_zone_'.$zone->id);
                $price = $this->price_after_discount($original_price, $discount);

                if($discount >= 100){
                    return back()->withErrors(['discount can not be greater than 100% !'])->withInput();
                }

                DB::table('zone_prices')
                    ->insert([
                        'zone_id'           => $zone->id,
                        'item_type'         => 'package',
                        'item_id'           => $new_package->id,
                        'original_price'    => $original_price,
                        'price'             => $price,
                        'discount'          => $discount,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ]);


            }
        }


        Transcode::add($new_package, [
            'name' => $request->name_ar,
            'description' => $request->description_ar,
            'what_you_learn'=> $request->what_you_learn_ar,
            'requirement'=> $request->requirement_ar,
            'who_course_for'=> $request->who_course_for_ar,
        ]);
        
        $this->doSlug($request->name, $new_package->id);

        return redirect(route('packages.index'))->with('success', 'Package Created Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Packages::find($id);
        $packageTransCodes = Transcode::evaluate($package, true, true);
        $packageTransCodes_fr = Transcode::evaluate($package, 'fr', true);
        $prices = DB::table('zones')
            ->leftJoin(DB::raw('(SELECT * FROM zone_prices WHERE item_type=\'package\' AND item_id=\''.$id.'\') AS zone_prices'),
                'zones.id', '=', 'zone_prices.zone_id')
            ->select(
                'zones.id',
                'zones.name',
                'original_price',
                'price',
                'discount'
            )
            ->get();
        return view('packages.edit')
            ->with('package', $package)
            ->with('packageTransCodes', $packageTransCodes)
            ->with('packageTransCodes_fr', $packageTransCodes_fr)
            ->with('prices', $prices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'name' => 'required',
            'price' => 'numeric|required',
            'extension_price' => 'numeric|required',
            'expire' => 'numeric|required',
            'extension_in_days' => 'numeric|required',
            'max_extension' => 'numeric|required',
            'description' => 'required',
            'discount' => 'numeric|required',
            'what_you_learn'=>'required',
            'requirement'=>'required',
            'who_course_for'=>'required',
            'enroll_msg'=>'required',
            'lang' => 'required',
            'course_id' => 'required',
            'certification'=>'numeric|required'
        ]);

        

        if($request->input('discount') > 100){
            return back()->withErrors(['discount can not be greater than 100% !'])->withInput();
        }

        if($request->input('max_extension') != 0 && $request->input('extension_in_days') != 0){


            if($request->input('max_extension') % $request->input('extension_in_days') != 0){
                return back()->withErrors(['max number of extension days must be divisible by extend days !'])->withInput();
            }
        }

        $price = $this->price_after_discount($request->input('price'), $request->input('discount'));

        $package = Packages::find($id);
        $package->name = $request->input('name');
        $package->original_price = $request->input('price');
        $package->price = $price;
        $package->expire_in_days = $request->input('expire');
        $package->extension_in_days = $request->input('extension_in_days');
        $package->extension_price = $request->input('extension_price');
        $package->max_extension_in_days = $request->input('max_extension');
        $package->discount = $request->input('discount');
        $package->description = $request->input('description');
        $package->requirement = $request->input('requirement');
        $package->what_you_learn = $request->input('what_you_learn');
        $package->who_course_for = $request->input('who_course_for');
        $package->enroll_msg = $request->input('enroll_msg');
        $package->course_id = $request->input('course_id');
        $package->lang = $request->input('lang');

        if($request->input('popular') == ''){
            $package->popular = 0;
        }else{
            $package->popular = 1;
        }

        $package->certification = $request->input('certification');
        if($request->input('certification')){
            $package->certification_title = $request->input('certification_title');
            $package->total_time = $request->course_hours;
        }

        if($request->hasFile('img')){
            $oldPath = $package->img;
            if(Storage::exists($oldPath)){
                Storage::delete($oldPath);
            }
            // store the pdf
            $package->img = $request->file('img')->store('public/package/imgs/');
        }

        if($request->hasFile('img_large')){
            $oldPath = $package->img_large;
            if(Storage::exists($oldPath)){
                Storage::delete($oldPath);
            }
            // store the pdf
            $package->img_large = $request->file('img_large')->store('public/package/imgs/');
        }

        if($request->hasFile('img_small')){
            $oldPath = $package->img_small;
            if(Storage::exists($oldPath)){
                Storage::delete($oldPath);
            }
            // store the pdf
            $package->img_small = $request->file('img_small')->store('public/package/imgs/');
        }


        if($request->hasFile('preview_video')){
            $oldPath = $package->preview_video_url;
            if(Storage::exists($oldPath)){
                Storage::delete($oldPath);
            }
            $package->preview_video_url = $request->file('preview_video')->store('public/package/preview/');
        }
        
        $package->save();

        /**
         * Store Prices
         */
        DB::table('zone_prices')->where(['item_type' => 'package', 'item_id' => $package->id])->delete();
        $zones = DB::table('zones')->get();
        foreach($zones as $zone){
            if($request->has('price_zone_'.$zone->id) && $request->input('price_zone_'.$zone->id) != ''){

                $original_price = $request->input('price_zone_'.$zone->id);
                $discount = $request->input('discount_zone_'.$zone->id);
                $price = $this->price_after_discount($original_price, $discount);

                if($discount >= 100){
                    return back()->withErrors(['discount can not be greater than 100% !'])->withInput();
                }

                DB::table('zone_prices')
                    ->insert([
                        'zone_id'           => $zone->id,
                        'item_type'         => 'package',
                        'item_id'           => $package->id,
                        'original_price'    => $original_price,
                        'price'             => $price,
                        'discount'          => $discount,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ]);


            }
        }


        Transcode::update($package, [
            'name' => $request->name_ar,
            'description' => $request->description_ar,
            'what_you_learn'=> $request->what_you_learn_ar,
            'requirement'=> $request->requirement_ar,
            'who_course_for'=> $request->who_course_for_ar,
        ]);

        Transcode::update($package, [
            'name' => $request->name_fr,
            'description' => $request->description_fr,
            'what_you_learn'=> $request->what_you_learn_fr,
            'requirement'=> $request->requirement_fr,
            'who_course_for'=> $request->who_course_for_fr,
        ], 'fr');
        
        $this->doSlug($request->name, $package->id);


        return \Redirect::to(route('packages.index'))->with('success', 'Package Edited Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $query= Packages::find($id);
        if($query->count()){
            if($query->active == 1){
                $title = $query->name;
                $query->active = 0 ;
                $query->save();
                return redirect(route('packages.index'))->with('success',"$title : Package Disabled");    
            }

            $title = $query->name;
            $query->active = 1;
            $query->save();
            return redirect(route('packages.index'))->with('success',"$title : Package Enabled");    
            // // delete all roles 
            // $roles = QuestionRoles::where('package_id','=', $id)->get();
            // if($roles->count()){
            //     foreach($roles as $role){
            //         $role->delete();       
            //     }
            // }
            // $query->delete();
           

        }
        return redirect(route('packages.index'))->with('error', 'Unkown Error: Package not found !!');
    }


    public function price_after_discount($original_price, $discount){
        $take_off = ($discount/100) * $original_price;
        $new_price = $original_price - $take_off;
        return round($new_price, 2);
    }

    public function packageByCourse(Locale $locale, PackageRepositoryInterface $packageRepository){
        $country_code = Zone::getLocation()->country_code;
        $package_selles_list = [];
        $event_selles_list = [];
        $course_slug = \Illuminate\Support\Facades\Input::get('course');
        $courseModel = \App\Course::where('slug', $course_slug)->first();
        if($courseModel){
            $course_id = $courseModel->id;
        }else{
            $course_id = null;
        }
        
        
        $events = \App\Event::where('course_id', $course_id)->where('end' , '>', now())
            ->where('active', 1)->get();
        $packages = \App\Packages::where('course_id', $course_id)->where('active', 1)->get();
        
        if($packages->first() || $events->first()){

            $package_selles_list = $packageRepository->getPackagesByCourse($course_id, $country_code, $locale->locale);
            
            if($events->first()){
            foreach($events as $event){
                $item = (object)[];
                $item->event = $event;

                $item->users_no = count(\App\EventUser::where('event_id', $event->id)->get());
                $total_no = 0;
                $rate = \App\Rating::where('event_id',$event->id)->get();
                $devisor = count($rate);
                foreach($rate as $i){
                    $total_no+= $i->rate;
                }
                if($devisor == 0){
                    $item->total_rate = 0;
                }else{
                    $item->total_rate = $total_no/$devisor;
                }


                array_push($event_selles_list, $item);
            }

            for($i=0;$i<count($event_selles_list);$i++){
                $val = $event_selles_list[$i]->users_no;
                $val2 = $event_selles_list[$i]->event;
                $val3 = $event_selles_list[$i]->total_rate;

                $j = $i-1;
                while($j>=0 && $event_selles_list[$j]->users_no < $val){
                    $event_selles_list[$j+1]->users_no = $event_selles_list[$j]->users_no;
                    $event_selles_list[$j+1]->package = $event_selles_list[$j]->event;
                    $event_selles_list[$j+1]->total_rate = $event_selles_list[$j]->total_rate;
                    $j--;
                }
                $event_selles_list[$j+1]->users_no = $val;
                $event_selles_list[$j+1]->package = $val2;
                $event_selles_list[$j+1]->total_rate = $val3;
            }
        }
            

        }else{
            $package = \App\Packages::all('course_id')->first();
            $courseModel = \App\Course::find($package->course_id);
            return \Redirect::to(route('package.by.course').'?course='.$courseModel->slug);
        }


        return view('PackageByCourse')
            ->with('best_sell', $package_selles_list)
            ->with('best_sell_event', $event_selles_list);

    }
}
