<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\room;
use App\Models\floor;
use Illuminate\Http\Request;
use App\DataTables\roomDataTable;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index','store']]);
         $this->middleware('permission:room-create', ['only' => ['create','store']]);
         $this->middleware('permission:room-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(roomDataTable $dataTable)
    {
        return $dataTable->render('room.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = item::all();
        $floor = floor::all();
        return view('room.create',compact('items','floor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number'=>'required|min:1|unique:rooms,room_number',
            'floor_id'=>'required|min:1',
            'items'=>'required|array',
            'status'=>'required|min:1',
        ]);

      $room =  room::create([
            'room_number'=>$request->room_number,
            'floor_id'=>$request->floor_id, 
            'created_by'=>Auth::user()->id,
            'status'=>$request->status]
        );

        $room->item()->attach($request->items);

        return redirect()->route('room.index')->with('message','Room Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(room $room)
    {
        return view('room.show',compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(room $room)
    {   $items= item::all();
        $floor = floor::all();
        $items_selected = $room->item->pluck('id')->toArray();
        return view('room.edit',compact('room','items','items_selected','floor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, room $room)
    {
        $request->validate([
            'room_number'=>'required|min:1',
'floor_id'=>'required|min:1',
'items'=>'required|array',
'status'=>'required|min:1',
        ]);

        $room->update([
            'room_number'=>$request->room_number,
            'floor_id'=>$request->floor_id, 
            'updated_by'=>Auth::user()->id,
            'status'=>$request->status]
        );

        $room->item()->sync($request->items);

        return redirect()->route('room.index')->with('message','Room updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(room $room)
    {
        $room->deleted_by = Auth::user()->id;
        $room->save();
        $room->delete();
        return redirect()->route('room.index')->with('message','Room Deleted');
    }
}
