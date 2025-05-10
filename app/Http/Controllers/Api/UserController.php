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
            return $this->api_response(true, 'Fetched successfully', $users);
    }
    public function store(Request $request){

        $data= $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return $this->api_response(true, 'Created successfully', ['user' => $user], 200);
    }

    public function show(string $id){
        $data = User::findOrFail($id);

        if(!isset($data)){
            return $this->api_response(false, 'User Not Found', [], 404);
        }
         return $this->api_response(true, 'Fetched successfully', $data);
    }

    public function update(Request $request , string $id){

        $user = User::query()->find($id);
        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
       return $this->api_response(true, 'update done ', $user);

    }

    public function destroy(string $id)
    {
       $user = User::query()->find($id);
        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }
        $user->delete();
        return $this->api_response(true, 'Deleted successfully');
    }

    public function login( Request $request ){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            $res = [
                'errors' => $validator->errors(),
            ];
            return $this->api_response(false, 'Validation Error', $res, 422);
        }

        $user = User::query()->where('email' , $request->email)->first();
        $check = Hash::check($request->password , $user->password);

        if($check){

            $res['user'] = $user ;
            $res['token']= $user->createToken('api')->plainTextToken;
            return $this->api_response(true, 'Login Successful', $res);
        } else {
            return $this->api_response(false, 'Wrong password', [], 400);
        }

    }

    public function logout(){
        $user = auth('api')->user();
        // $user->currentAccessToken()->delete();
        return $this->api_response(true, 'Logout Successfully');
    }


    public function myData(){
        //how to restore auth user's data
        dd( auth('api')->user());
    }

}
