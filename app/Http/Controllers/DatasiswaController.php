<?php

namespace App\Http\Controllers;

use App\Models\Datasiswa; // Import model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // untuk validasi API nantinya

class DatasiswaController extends Controller
{
    
     /**
     * index
     *
     * @return void
     */
    public function index() {

    	//get data from table posts
        $posts = Datasiswa::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Datasiswa',
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
        $post = Datasiswa::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Datasiswa',
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
            'nama'   => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $post = Datasiswa::create([
            'nama'     => $request->nama,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'alamat'     => $request->alamat,
            'no_hp'   => $request->no_hp
        ]);

        //success save to database
        if($post) {

            return response()->json([
                'success' => true,
                'message' => 'Datasiswa Created',
                'data'    => $post  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Datasiswa Failed to Save',
        ], 409);

    }
     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Datasiswa $datasiswa)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $datasiswa = Datasiswa::findOrFail($datasiswa->id);

        if($datasiswa) {

            //update post
            $datasiswa->update([
	            'nama'     => $request->nama,
	            'tanggal_lahir'   => $request->tanggal_lahir,
	            'alamat'     => $request->alamat,
	            'no_hp'   => $request->no_hp
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Datasiswa Updated',
                'data'    => $datasiswa  
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Datasiswa Not Found'
        ], 404);

    }
}
