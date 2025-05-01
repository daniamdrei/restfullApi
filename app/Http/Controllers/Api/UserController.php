<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
            return response()->json([
                'message'=>'fetch data successfully',
                'data'=>$users
            ] , 200);
    }
    public function store(Request $request){

        //validation
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        if($validated->fails()){
            return response()->json([
                'error'=>$validated->errors()
            ] , 422);
        }
        //if every thing alright then insert into table

        $data= $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json([
            'message'=>'data stored successfully',
            'user'=>$user,
        ],201);
    }

    public function show(string $id){
        $data = User::findOrFail($id);

        if(!isset($data)){
            return response()->json([
                'error'=>'User Not Found'
            ] , 404);
        }
         return response()->json([
            'message'=>'user details',
            'data'=>$data
         ]);
    }

    public function update(Request $request , User $user){

        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $res = [
                'errors' => $validator->errors(),
            ];
           return response()->json(['error'=>$validator->errors()] , 422);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::query()->create($data);
        return response()->json([
            'message'=>'user updated successfully',
            'user'=>$user,
        ],201);

    }

    public function destroy(User $user)
    {
        $data = $user->delete();

        if (!$data) {
            return response()->json([
                'error'=>'User Not Found'
            ] , 404);
        }
        return response()->json(['message'=> 'Deleted successfully']);
    }


}
