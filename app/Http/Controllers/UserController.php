<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function index(){
        return view('user/index');
    }

    public function userList(){
        return response()->json(User::all());
    }

    public function edit(){
        return view('user/edit');
    }

    public function update(Request $request,$id){
        
        //Serverside validation
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required',
            'organization'=>'required'
        ]);

        $user= User::find($id);
        
        //To update any changes to user profile
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->organization=$request->input('organization');
        $user->photo=$request->input('photo');
        $user->department=$request->input('department');
        $user->position=$request->input('position');

        $user->save();

        return response()->json("sucess");

    }

    public function detailRecord($id){
        $user= User::find($id);
        return response()->json($user);
    }

    public function detail($id){
        return view('user/detail')->with('id',$id);
    }

    public function delete($id){
        $user= User::find($id);
        $user->delete();
        Auth::logout();
        return redirect('/login');
    }
}
