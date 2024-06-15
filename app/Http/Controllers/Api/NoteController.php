<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    //index
    public function index(){
        $notes = Note::all();
        return response()->json([
            'message' => 'success',
            'data' => $notes
        ], 200);
    }

    //store
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_pin' => 'required',
        ]);

        $note = Note::create($request->all());

        //if request has image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $note->image = $image_name;
            $note->save();
        }

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 201);
    }

    //update
    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_pin' => 'required',
        ]);

        $note = Note::find($id);
        $note->update($request->all());

        //if request has image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $note->image = $image_name;
            $note->save();
        }

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 200);
    }

    //delete
    public function destroy($id){
        $note = Note::find($id);
        $note->delete();

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    //show
    public function show($id){
        $note = Note::find($id);

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 200);
    }
}
