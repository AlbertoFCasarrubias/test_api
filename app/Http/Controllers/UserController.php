<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Datos;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $objects = User::all();
        foreach ($objects as $user) {
            $user->datos;
        }
        return response()->json($objects);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',            
            'role' => 'required|in:admin,visitante',
            'name' => 'required',
            'birthday' => 'required',
            'active' => 'required',
            'address' => 'required',
            'size' => 'required',
            'country' => 'required',
            'balance' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }

        $object = User::where('email' , $request->email)->first();
        if ($object) {
            return response()->json('email is registered',401);
        }

        $object = new User();
        $object->email= $request->email;
        $object->password= Hash::make($request->password);        
        $object->role= $request->role;
        $object->save();

        $datos = new Datos();
        $datos->name = $request->name;
        $datos->country = $request->country;
        $datos->balance = $request->balance;
        $datos->birthday = $request->birthday;
        $datos->phone = $request->phone;
        $datos->active = $request->active;
        $datos->address = $request->address;
        $datos->size = $request->size;
        $datos->user_id = $object->id;
        $datos->save();

        return $this->show($object->id);
    }

    public function show($id)
    {
        $object = User::find($id);
        $object->datos;

        return response()->json($object);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',            
            'role' => 'required|in:admin,visitante',
            'name' => 'required',
            'birthday' => 'required',
            'active' => 'required',
            'address' => 'required',
            'size' => 'required',
            'country' => 'required',
            'balance' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }

        $object= User::find($id);
        $object->email= $request->email;

        $datos= Datos::find($id);
        $datos->name = $request->name;
        $datos->country = $request->country;
        $datos->balance = $request->balance;
        $datos->birthday = $request->birthday;
        $datos->phone = $request->phone;
        $datos->active = $request->active;
        $datos->address = $request->address;
        $datos->size = $request->size;
        

        if ($request->password) {
            $object->password= Hash::make($request->password);
        }

        $object->role= $request->role;
        $object->update();
        $datos->update();
        return $this->show($id);
    }

    public function destroy($id)
    {
        $object = User::find($id);

        if (!$object) {
            return response()->json('User not exist',401);
        }

        $object->delete();

        return response()->json('user removed successfully');
    }


}
