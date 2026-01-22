<?php

namespace App\Http\Controllers;

use App\Models\item;
use Illuminate\Http\Request;
use App\DataTables\itemDataTable;

class ItemController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:item-list|item-create|item-edit|item-delete', ['only' => ['index','store']]);
         $this->middleware('permission:item-create', ['only' => ['create','store']]);
         $this->middleware('permission:item-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:item-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(itemDataTable $dataTable)
    {
        return $dataTable->render('settings.items.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:1|unique:items,name',
            'description'=>'nullable|max:250'
        ]);

        item::create([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        return redirect()->route('item.index')->with('message','Item creted');
    }

    /**
     * Display the specified resource.
     */
    public function show(item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(item $item)
    {
        return view('settings.items.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, item $item)
    {
        $request->validate([
            'name'=>'required|min:1|unique:items,name,'.$item->id,
            'description'=>'nullable|max:250'
        ]);

        $item->update([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        return redirect()->route('item.index')->with('message','Item update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(item $item)
    {
        $item->delete();
        return redirect()->route('settings.item.index')->with('message','Item update');
    }
}
