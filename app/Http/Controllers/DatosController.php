<?php

namespace App\Http\Controllers;

use App\Models\Datos;

class DatosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $objects = Datos::all();
        return response()->json($objects);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mail' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }

        $object = User::where('mail' , $request->email)->first();
        if ($object) {
            return response()->json('email is registered',401);
        }

        $user = new User();
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password= Hash::make($request->password);
        $user->role= 'admin';
        $user->save();

        $object = new Datos();
        $object->id= $user->id;
        $object->name= $request->name;
        $object->birthdate= $request->birthdate;
        $object->valid= true;
        $object->address= $request->address;
        $object->size= $request->size;
        $object->country= $request->country;
        $object->balance= $request->balance;
        $object->phone= $request->phone;
        $object->created= $date->format('Y-m-d H:i:s');

        $object->save();

        return response()->json($object);
    }
}
