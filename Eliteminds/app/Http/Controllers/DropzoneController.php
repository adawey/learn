<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DropzoneController extends Controller
{

    public $temp_path = 'temp';
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(Request $request){
        $path = storage_path($this->temp_path);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * @param $temp_file_name
     * @param $newLocation
     */
    public function upload($temp_file_name, $newLocation){
        //$dirSeparetor = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? '\\': '/';
        $dirSeparetor = '/';
        $path = storage_path($this->temp_path.$dirSeparetor.$temp_file_name);
        if(file_exists($path)){
            try{
                rename($path, $newLocation);
            }catch(\Exception $e){
                //
            }

        }
    }
}
