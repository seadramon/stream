<?php

namespace Streamcms\Http\Controllers;

use Streamcms\Models\Tips;
use Illuminate\Http\Request;

use Html;
use Validator;
use Redirect;
use Session;

class TipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tips = Tips::paginate(15);

        return view('pages.tips.index')
            ->with('tipss', $tips);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tips.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return Redirect::to('tips/create')
                ->withErrors($validator);
        } else {
            $data = Tips::create($request->all());

            Session::flash('message', 'Successfully created tips!');
            return Redirect::to('tips');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Streamcms\Models\Tips  $tips
     * @return \Illuminate\Http\Response
     */
    public function show(Tips $tips)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Streamcms\Models\Tips  $tips
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tips = Tips::find($id);

        return view('pages.tips.create')
            ->with('tips', $tips)
            ->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Streamcms\Models\Tips  $tips
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return Redirect::to('tips/create')
                ->withErrors($validator);
        } else {
            $data = Tips::find($id);
            $data->update($request->all());

            Session::flash('message', 'Successfully updated tips!');
            return Redirect::to('tips');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Streamcms\Models\Tips  $tips
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tips = Tips::find($id);
        $tips->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the tips!');
        return Redirect::to('tips');
    }

    public function search(Request $request)
    {
        $tips = Tips::where('nama', 'like', '%'.trim($request->nama).'%')->paginate(15);
        
        return view('pages.tips.index')
            ->with('tipss', $tips);
    }

    public function export()
    {
        $tips = Tips::get(['id', 'nama', 'description']);

        return response()->json($tips);
    }
}
