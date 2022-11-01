<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivationGroupController extends Controller
{
    public function create(){
        return view('admin.activationGroup');
    }

    function strigToBinary($string)
    {
        $characters = str_split($string);

        $binary = [];
        foreach ($characters as $character) {
            $data = unpack('H*', $character);
            $binary[] = base_convert($data[1], 16, 2);
        }

        return implode(' ', $binary);
    }

    function binaryToString($binary)
    {
        $binaries = explode(' ', $binary);

        $string = null;
        foreach ($binaries as $binary) {
            $string .= pack('H*', dechex(bindec($binary)));
        }

        return $string;
    }


    public function store(Request $request){
        $package_id             = $request->package_id;
        $event_id               = $request->event_id;
        $packageActivationCount = 0;
        $eventActivationCount   = 0;

//        dd($request->file('csv_file'));
        $this->validate($request, [
            'csv_file'              => 'required|mimes:csv,txt',
        ], [
            'csv_file.required'     => 'The CSV File is required',
            'csv_file.mimes'        => 'The file must be of format .CSV',
        ]);

        /**
         * upload part
         */
        $path = storage_path('temp/csv');
        $file = $request->file('csv_file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $csv = $file->move($path, $name);

        /**
         * convert csv to array
         */
        $csv_array = $this->csvToArray($csv);
        $csv_emails = array_column($csv_array, 'email');

        /**
         * activate package for this group of users
         */
        if($package_id) {
            $packageActivationCount = $this->packageActivation($csv_emails, $package_id);
        }

        /**
         * activate event for this group of users
         */
        if($event_id) {
            $eventActivationCount = $this->eventActivation($csv_emails, $event_id);
        }

        /**
         * Delete the file from temps
         */
        unlink($csv);

        return back()->with('success', 'Package Activation Group Accomplished for '.$packageActivationCount.' User. Event Activation Group Accomplished for '. $eventActivationCount.' User');
    }

    public function eventActivation(array $csv_emails, int $event_id){
        /**
         * Verify user is registered. and only get registered users.
         * Users that do not have this event
         */
        $users = DB::table('users')->whereIn('email', $csv_emails)
            // get users that do not have this package..
            ->leftJoin('event_user', function($join)use($event_id){
                $join->on('users.id', '=','event_user.user_id');
                $join->on('event_user.event_id', '=', DB::raw("$event_id"));
            })
            ->whereNull('event_user.event_id')
            ->select('users.id')
            ->get()
            ->pluck('id');

        /**
         * Build user_packages table query
         */
        $query = array();
        for($i=0; $i < count($users); $i++){
            $q = [
                'user_id'       => $users[$i],
                'event_id'      => $event_id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
            array_push($query, $q);
        }

        DB::table('event_user')
            ->insert($query);
        return count($query);
    }

    public function packageActivation(array $csv_emails, int $package_id){
        /**
         * Verify user is registered. and only get registered users.
         * Users that do not have this package
         */
        $users = DB::table('users')->whereIn('email', $csv_emails)
            // get users that do not have this package..
            ->leftJoin('user_packages', function($join)use($package_id){
                $join->on('users.id', '=','user_packages.user_id');
                $join->on('user_packages.package_id', '=', DB::raw("$package_id"));
            })
            ->whereNull('user_packages.package_id')
            ->select('users.id')
            ->get()
            ->pluck('id');

        /**
         * Build user_packages table query
         */
        $query = array();
        for($i=0; $i < count($users); $i++){
            $q = [
                'user_id'       => $users[$i],
                'package_id'    => $package_id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
            array_push($query, $q);
        }

        DB::table('user_packages')
            ->insert($query);
        return count($query);
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $errors = [];

        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {

                if (!$header)
                    $header = $row;
                else {
                    try{
                        $data[] = array_combine($header, $row);
                    } catch(\Exception $e){
                        array_push($errors, $row[0]);
                    }

                }
            }
            fclose($handle);
        }



        return $data;
    }
}
