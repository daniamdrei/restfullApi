<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    public function index(){
        $posts = Post::all();

        return $this->api_response(true , 'fetch data successfully', $posts , 200 );

    }
    public function store(Request $request){

        $data = $request->all();
        $post = Post::query()->create($data);
        return $this->api_response(true, 'Created successfully', ['post' => $post], 200);

    }

    public function show(string $id){
        $data = Post::findOrFail($id);

        if(!isset($data)){
            return $this->api_response(false, 'post Not Found', [], 404);
        }
        return $this->api_response(true , 'Fetched successfully' ,$data , 200);
    }

    public function update(Request $request , string $id){

        $post = Post::findOrFail($id);
        if(!isset($post)){
            return $this->api_response(false, 'post Not Found', [], 404);
        }

            $data = $request->all();
            $post->update($data);
            return $this->api_response(true, 'update done ', $data);

    }

    public function destroy(string $id)
    {
        $data = Post::findOrFail($id);

        if (!isset($data)) {
            return $this->api_response(false, 'post Not Found', [], 404);
        }

        $data->delete();
        return $this->api_response(true, 'Deleted successfully');
    }













    // public function index(){
    //     $posts = Post::all();
    //         return response()->json([
    //             'message'=>'fetch data successfully',
    //             'data'=>$posts
    //         ] , 200);
    // }
    // public function store(Request $request){

    //     //validation
    //     $validated = Validator::make($request->all(), [
    //         'user_id' => 'require|exist:exists:users,id',
    //         'title' => 'required',
    //         'description' => 'require|max:255',
    //     ]);
    //     if($validated->fails()){
    //         return response()->json([
    //             'error'=>$validated->errors()
    //         ] , 422);
    //     }
    //     //if every thing alright then insert into table

    //     $data= $request->all();
    //     $post = Post::create($data);

    //     return response()->json([
    //         'message'=>'data stored successfully',
    //         'post'=>$post,
    //     ],201);
    // }

    // public function show(string $id){
    //     $data = Post::findOrFail($id);

    //     if(!isset($data)){
    //         return response()->json([
    //             'error'=>'Post Not Found'
    //         ] , 404);
    //     }
    //      return response()->json([
    //         'message'=>'post details',
    //         'data'=>$data
    //      ]);
    // }

    // public function update(Request $request , Post $post){

    //     //validation
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'require|exist:exists:users,id',
    //         'title' => 'required',
    //         'description' => 'require|max:255',
    //     ]);

    //     if ($validator->fails()) {
    //         $res = [
    //             'errors' => $validator->errors(),
    //         ];
    //        return response()->json(['error'=>$validator->errors()] , 422);
    //     }

    //     $data = $request->all();
    //     $data['password'] = Hash::make($data['password']);
    //     $post->update($data);
    //     return response()->json([
    //         'message'=>'post updated successfully',
    //         'post'=>$post,
    //     ],201);

    // }

    // public function delete(Post $post)
    // {
    //     $data = $post->delete();

    //     if (!$data) {
    //         return response()->json([
    //             'error'=>'Post Not Found'
    //         ] , 404);
    //     }
    //     $post->delete();
    //     return response()->json(['message'=> 'Deleted successfully']);
    // }

}
