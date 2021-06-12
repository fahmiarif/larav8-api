<?php

namespace App\Http\Controllers;

use App\Models\Datakelas; // Import model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // untuk validasi API nantinya


class DatakelasController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index() {

    	//get data from table posts
        $posts = Datakelas::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Datakelas',
            'data'    => $posts  
        ], 200);

    }
     /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id) {

        //find post by ID
        $post = Datakelas::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Datakelas',
            'data'    => $post 
        ], 200);

    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_kelas'   => 'required',
            'jurusan' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $post = Datakelas::create([
            'nama_kelas'     => $request->nama_kelas,
            'jurusan'   => $request->jurusan
        ]);

        //success save to database
        if($post) {

            return response()->json([
                'success' => true,
                'message' => 'Datakelas Created',
                'data'    => $post  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Datakelas Failed to Save',
        ], 409);

    }
     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $datakelas
     * @return void
     */
    public function update(Request $request, Datakelas $datakela)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_kelas'   => 'required',
            'jurusan' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find datakelas by ID
        $datakela = Datakelas::findOrFail($datakela->id);

        if($datakela) {

            //update datakelas
            $datakela->update([
            	'nama_kelas'     => $request->nama_kelas,
            	'jurusan'   => $request->jurusan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Datakelas Updated',
                'data'    => $datakela  
            ], 200);

        }

        //data datakelas not found
        return response()->json([
            'success' => false,
            'message' => 'Datakelas Not Found'
        ], 404);

    }
   	/**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find post by ID
        $post = Datakelas::findOrfail($id);

        if($post) {

            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Datakelas Deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Datakelas Not Found',
        ], 404);
    }
}
