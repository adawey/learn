<?php

namespace App\Http\Controllers;

use App\Transcode\Transcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    public function add_manual(Request $req){
        $this->validate($req, [
            'user_id'   => 'required|int',
            'event_id'  => 'required|int',
        ]);

        $event_user = \App\EventUser::where('user_id', $req->user_id)->where('event_id', $req->event_id)->first();


        if($event_user){
            return back()->with('error', 'User already have this event !');
        }

        $newEvent = new \App\EventUser;
        $newEvent->user_id = $req->user_id;
        $newEvent->event_id = $req->event_id;
        $newEvent->save();

        $event_details = \App\Event::find($req->event_id);

        try{

            Mail::to(Auth::user()->email)->send(new \App\Mail\EnrollConfirmationMail($event_details->enroll_msg));
        }catch(\Exception $e){
            /**
             * do nothing !
             */
        }

        return back()->with('success', 'Event added successfully ');
    }



    public function create(){
        return view('admin.event.create');
    }


    public function price_after_discount($original_price, $discount){
        $take_off = ($discount/100) * $original_price;
        $new_price = $original_price - $take_off;
        return round($new_price, 2);
    }

    public function store(Request $req){



        $event = new \App\Event;
        $event->name = $req->input('title');
        $event->whatsapp = $req->input('whatsapp');
        $event->zoom = $req->input('zoom');
        $event->lang = $req->input('lang');
        $event->description = $req->input('description');
        $event->what_you_learn = $req->what_you_learn ? $req->what_you_learn : null;
        $event->requirement = $req->requirement ? $req->requirement : null;
        $event->who_course_for = $req->who_course_for ? $req->who_course_for : null;
        $event->enroll_msg = $req->enroll_msg ? $req->enroll_msg : null;
        $event->start = $req->input('start');
        $event->end = $req->input('end');
        $event->price = $req->input('originalPrice') - ($req->input('originalPrice') * $req->input('discount') / 100);
        $event->discount = $req->input('discount');
        $event->original_price = $req->input('originalPrice');
        $event->total_time = $req->total_time;
        $event->total_lecture = $req->total_lecture;
        $event->course_id = $req->input('course_id');
        $event->certification = $req->input('certification');
        $event->certification_title = $req->input('certification_title');

        if($req->hasFile('picture')){
            if($req->file('picture')->isValid()){
                $event->img = $req->file('picture')->store('public/events');
            }else{
                return 'Picture file not valid';
            }
        }

        $event->save();

        $free_packages = explode(',', $req->free_package_id);
        if(count($free_packages)){
            foreach($free_packages as $package_id){
                DB::table('event_free_packages')
                    ->insert([
                        'event_id'      => $event->id,
                        'package_id'    => $package_id,
                    ]);
            }
        }

        foreach(json_decode($req->input('days')) as $d){
            $day = new \App\EventTime;
            $day->day = $d->day;
            $day->from = $d->from;
            $day->to = $d->to;

            $event->event_times()->save($day);
        }



        // translation
        Transcode::add($event, [
            'name' => $req->title_ar,
            'description' => $req->description_ar,
            'what_you_learn'=> $req->what_you_learn_ar,
            'requirement'=> $req->requirement_ar,
            'who_course_for'=> $req->who_course_for_ar,
        ]);

        /**
         * Store Prices
         */
        $zones = DB::table('zones')->get();
        foreach($zones as $zone){
            if($req->has('price_zone_'.$zone->id) && $req->input('price_zone_'.$zone->id) != ''){

                $original_price = $req->input('price_zone_'.$zone->id);
                $discount = $req->input('discount_zone_'.$zone->id);
                $price = $this->price_after_discount($original_price, $discount);


                DB::table('zone_prices')
                    ->insert([
                        'zone_id'           => $zone->id,
                        'item_type'         => 'event',
                        'item_id'           => $event->id,
                        'original_price'    => $original_price,
                        'price'             => $price,
                        'discount'          => $discount,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ]);


            }
        }




        return 0;
    }

    public function user_show_event($cat){
        return view('user.event')->with('cat', $cat);
    }


    public function event_check(Request $req){
        $this->validate($req, [
            'user_id'   => 'required|int',
            'event_id'  => 'required|int',
        ]);
        $event = \App\Event::find($req->event_id);
        $event_user = \App\EventUser::where('user_id', $req->user_id)->where('event_id', $req->event_id)->first();
        $event_check = \App\EventCheck::where('user_id', $req->user_id)->where('event_id', $req->event_id)->first();



        if($event_user){
            return back()->with('error', 'User already have this event !');
        }
        if($event_check){
            return back()->with('error', 'User already Authorized to this event !');
        }

        $event_check = new \App\EventCheck;
        $event_check->user_id = $req->user_id;
        $event_check->event_id = $req->event_id;
        $event_check->save();


        $m = new \App\Message;
        $m->from_user_id = 2;
        $m->from_user_type = 'admin';
        $m->message = 'You can buy the interactive course -'.$event->name.'- <a href="'.route('public.event.view', $req->event_id).'"> click here </a>';
        $m->to_user_id = $req->user_id;
        $m->to_user_type = 'user';
        $m->save();

        return back()->with('success', 'Event added successfully ');

    }

    public function index(){
        return view('admin.event.index');
    }

    public function edit($id){
        $event = \App\Event::find($id);
        $eventTransCodes = Transcode::evaluate($event, true, true);
        $eventTransCodes_fr = Transcode::evaluate($event, 'fr', true);
        $prices = DB::table('zones')
            ->leftJoin(DB::raw('(SELECT * FROM zone_prices WHERE item_type=\'event\' AND item_id=\''.$id.'\') AS zone_prices'),
                'zones.id', '=', 'zone_prices.zone_id')
            ->select(
                'zones.id',
                'zones.name',
                'original_price',
                'price',
                'discount'
            )
            ->get();
        return view('admin.event.edit')
            ->with('event', $event)
            ->with('eventTransCodes', $eventTransCodes)
            ->with('eventTransCodes_fr', $eventTransCodes_fr)
            ->with('prices', $prices);
    }

    public function update(Request $req){
        
        $event = \App\Event::find($req->event_id);
        if(!$event){
            return 'Event not found !';
        }

        $event->active = $req->active == 'true' ? 1: 0;

        $event->name = $req->input('title');
        $event->lang = $req->input('lang');
        $event->whatsapp = $req->input('whatsapp');
        $event->zoom = $req->input('zoom');

        $event->description = $req->input('description');
        $event->what_you_learn = $req->what_you_learn ? $req->what_you_learn : null;
        $event->requirement = $req->requirement ? $req->requirement : null;
        $event->who_course_for = $req->who_course_for ? $req->who_course_for : null;
        $event->enroll_msg = $req->enroll_msg ? $req->enroll_msg : null;

        $event->price = $req->input('originalPrice') - ($req->input('originalPrice') * $req->input('discount') / 100);
        $event->discount = $req->input('discount');
        $event->original_price = $req->input('originalPrice');
        $event->total_time = $req->total_time;
        $event->total_lecture = $req->total_lecture;
        $event->certification = $req->input('certification');
        $event->certification_title = $req->input('certification_title');

        $event->course_id = $req->input('course_id');

        if($req->hasFile('picture')){
            if($req->file('picture')->isValid()){
                $oldPath = $event->img;
                if(Storage::exists($oldPath)){
                    Storage::delete($oldPath);
                }
                // store the img

                $event->img = $req->file('picture')->store('public/events');
            }else{
                return 'Picture file not valid';
            }
        }
        $event->save();

        if($req->free_package_id){
            DB::table('event_free_packages')->where('event_id', $event->id)->delete();
            $free_packages = explode(',', $req->free_package_id);
            if(count($free_packages)){
                foreach($free_packages as $package_id){
                    DB::table('event_free_packages')
                        ->insert([
                            'event_id'      => $event->id,
                            'package_id'    => $package_id,
                        ]);
                }
            }    
        }

        foreach(\App\EventTime::where('event_id', $event->id)->get() as $time){
            $time->delete();
        }

        foreach(json_decode($req->input('days')) as $d){
            $day = new \App\EventTime;
            $day->day = $d->day;
            $day->from = $d->from;
            $day->to = $d->to;

            $event->event_times()->save($day);
        }

        Transcode::update($event, [
            'name' => $req->title_ar,
            'description' => $req->description_ar,
            'what_you_learn'=> $req->what_you_learn_ar,
            'requirement'=> $req->requirement_ar,
            'who_course_for'=> $req->who_course_for_ar,
        ]);

        Transcode::update($event, [
            'name' => $req->title_fr,
            'description' => $req->description_fr,
            'what_you_learn'=> $req->what_you_learn_fr,
            'requirement'=> $req->requirement_fr,
            'who_course_for'=> $req->who_course_for_fr,
        ], 'fr');


        /**
         * Store Prices
         */
        DB::table('zone_prices')->where(['item_type' => 'event', 'item_id' => $event->id])->delete();
        $zones = DB::table('zones')->get();
        foreach($zones as $zone){
            if($req->has('price_zone_'.$zone->id) && $req->input('price_zone_'.$zone->id) != ''){

                $original_price = $req->input('price_zone_'.$zone->id);
                $discount = $req->input('discount_zone_'.$zone->id);
                $price = $this->price_after_discount($original_price, $discount);


                DB::table('zone_prices')
                    ->insert([
                        'zone_id'           => $zone->id,
                        'item_type'         => 'event',
                        'item_id'           => $event->id,
                        'original_price'    => $original_price,
                        'price'             => $price,
                        'discount'          => $discount,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ]);


            }
        }

        return 0;
    }
    
    
    public function delete($id){
        $event = \App\Event::find($id);
        if($event){
            // return $event;
            $event->delete();
        }
        
    }
}
