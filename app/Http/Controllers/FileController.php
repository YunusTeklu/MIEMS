<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'photo'=>'image|nullable|max:1999'
        ]);
        
        //To handle image upload
        if($request->hasFile('photo'))
        {
            //Get filename with extension
            $fileNameWithExt=$request->file('photo')->getClientOriginalName();

            //Get just filename
            $fileName=pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get just extension
            $extension=$request->file('photo')->getClientOriginalExtension();

            //Filename to be stored
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload Image
            $path=$request->file('photo')->storeAs('public/images',$fileNameToStore);
               
        }
        else{
            $fileNameToStore='noImage.jpg';
        }

        return response()->json($fileNameToStore);

    }

    public function downloadImage(Request $request, $fileName)
    {
        $path='public/storage/images/'.$fileName;
        return response()->download($path);
    }

    public function deleteImage(Request $request, $fileName)
    {
        $path='public/storage/images/'.$fileName;
        try{
            File::delete($path);
            $sucess="true";
        }catch (FileNotFoundException $e){
            $sucess="false";
        }
        
        return response()->json($sucess);
    }
}
