<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PostModel;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $posts = PostModel::latest()->get();
                return response([
                    'success' => true,
                    'message' => 'List Semua Posts',
                    'data' => $posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $post = PostModel::create([
                'title'     => $request->title,
                'price'   => $request->price,
                'image'   => $request->image
            ]);

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Disimpan!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Disimpan!',
            ], 400);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = PostModel::whereId($id)->first();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
        {
            //validate data
            $validator = Validator::make($request->all(), [
                'title'     => 'required',
                'price'   => 'required',
                'image' => 'required',
            ],
                [
                    'title.required' => 'Masukkan Title Post !',
                    'price.required' => 'Masukkan price Post !',
                    'image.required' => 'Masukkan image Post !',
                ]
            );

             if ($validator->fails()) {
                        return response()->json($validator->errors(), 400);
                    }

                  $post = PostModel::findOrFail($id);

                        if($post) {

                            //update post
                            $post->update([
                                'title'     => $request->title,
                                'price'   => $request->price,
                                'image'=> $request->image,
                            ]);

                            return response()->json([
                                'success' => true,
                                'message' => 'Post Updated',
                                'data'    => $post
                            ], 200);

                        }

                        //data post not found
                        return response()->json([
                            'success' => false,
                            'message' => 'Post Not Found',
                        ], 404);



        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=PostModel::find($id);
        if($product){
            $product->delete();

            return response()->json([
                'message'=>'product berhasil di hapus',
                'code'=>200
            ]);
        }else{
            return response()->json([
                'message'=>'product dengan id:$id tidak tersedia',
                'code'=>400
            ]);
        }
    }
}
