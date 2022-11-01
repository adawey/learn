<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function uploadFile(Request $request){
        if($request->hasFile('upload')){
            $path = $request->file('upload')->store('public/ckeditor/images');
            $function_name = $request->CKEditorFuncNum;
            $file_public_path = url('/storage/ckeditor/images/'.basename($path));
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($function_name, '$file_public_path', 'Image Uploaded')</script>";

            @header('Content-Type: text/html; charset-utf-8');
            echo $response;
        }
    }
}
