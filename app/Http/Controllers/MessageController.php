<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\User;

class MessageController extends Controller
{
    public function inbox(){
        return view('message/inbox');
    }

    public function sent(){
        return view('message/sent');
    }

    public function inboxList($id){
        $user = User::find($id);
        $email= $user->email;
        $inboxes= Message::where('to','=',$email)->get();
        return response()->json($inboxes);
    }

    public function sentList($id){
        $user = User::find($id);
        $email= $user->email;
        $sentMessages=Message::where('from','=',$email)->get();
        return response()->json($sentMessages);
    }

    public function compose(){
        return view('message/compose');
    }

    public function store(Request $request){

        $this->validate($request, [
            'from'=>'required',
            'to'=>'required',
            'patient_name'=>'required',
            'patient_gender'=>'required',
            'patient_age'=>'required',
            'medical_image_type'=>'required',
            'state'=>'required',
            'algorithm'=>'required',
            'encrypted_image'=>'required',
            'encryption_time'=>'required',
            'image_size'=>'required',
            'image_name'=>'required'
        ]);

        $message= new Message();
        
        $message->from= $request->input('from');
        $message->to=$request->input('to');
        $message->patient_name=$request->input('patient_name');
        $message->patient_age=$request->input('patient_age');
        $message->patient_gender=$request->input('patient_gender');
        $message->medical_image_type=$request->input('medical_image_type');
        $message->note=$request->input('note');
        $message->state=$request->input('state');
        $message->algorithm=$request->input('algorithm');
        $message->encrypted_image=$request->input('encrypted_image');
        $message->encryption_time=$request->input('encryption_time');
        $message->image_size=$request->input('image_size');
        $message->image_name=$request->input('image_name');

        $message->save();

        return response()->json($message->id);

    }

    public function edit(){
        return view('message/edit');
    }

    public function update(Request $request,$id){

        $this->validate($request, [
            'from'=>'required',
            'to'=>'required',
            'patient_name'=>'required',
            'patient_gender'=>'required',
            'patient_age'=>'required',
            'medical_image_type'=>'required',
            'state'=>'required',
            'algorithm'=>'required',
            'encrypted_image'=>'required',
            'encryption_time'=>'required',
            'image_size'=>'required',
            'image_name'=>'required'
        ]);

        $message= Message::find($id);

        $message->from= $request->input('from');
        $message->to=$request->input('to');
        $message->patient_name=$request->input('patient_name');
        $message->patient_gender=$request->input('patient_gender');
        $message->patient_age=$request->input('patient_age');
        $message->medical_image_type=$request->input('medical_image_type');
        $message->note=$request->input('note');
        $message->state=$request->input('state');
        $message->algorithm=$request->input('algorithm');
        $message->encrypted_image=$request->input('encrypted_image');
        $message->encryption_time=$request->input('encryption_time');
        $message->image_size=$request->input('image_size');
        $message->image_name=$request->input('image_name');

        $message->save();

        return response()->json();

    }

    public function detail($id){
        return view('message/detail')->with('id', $id);
    }

    public function detailRecord($id){
        $message= Message::find($id);
        return response()->json($message);
    }

    public function delete($id){
        $message= Message::find($id);
        $message->delete();
        return response()->json("success");
    }
}
