<?php

namespace Streamcms\Http\Controllers;

use Streamcms\Models\Medicine;
use Streamcms\Models\Keyword;

use Illuminate\Http\Request;

use Html;
use Validator;
use Redirect;
use Session;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicine = Medicine::paginate(15);

        return view('pages.medicine.index')
            ->with('medicines', $medicine);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keyword = Keyword::get()->pluck('nama', 'id');

        return view('pages.medicine.create')
            ->with('keyword', $keyword);
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
            return Redirect::to('medicine/create')
                ->withErrors($validator);
        } else {
            $data = Medicine::create($request->except('keyword'));

            $keywords = $request['keyword'];
            if (is_array($keywords) && count($keywords) > 0) {
                foreach ($keywords as $keyword) {
                    $data->assignKeyword($keyword);    
                }
            }

            Session::flash('message', 'Successfully created medicine!');
            return Redirect::to('medicine');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Streamcms\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Streamcms\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medicine = Medicine::find($id);
        $keyword = Keyword::get()->pluck('nama', 'id');

        return view('pages.medicine.create')
            ->with('medicine', $medicine)
            ->with('keyword', $keyword)
            ->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Streamcms\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return Redirect::to('medicine/create')
                ->withErrors($validator);
        } else {
            $data = Medicine::find($id);
            $data->update($request->except('keyword'));

            $keywords = $request['keyword'];
            if (is_array($keywords) && count($keywords) > 0) {
                $data->revokeKeyword();
                $data->keyword()->attach($keywords);  
            }

            Session::flash('message', 'Successfully updated medicine!');
            return Redirect::to('medicine');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Streamcms\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nerd = Medicine::find($id);
        $nerd->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the medicine!');
        return Redirect::to('medicine');
    }

    public function search(Request $request)
    {
        $medicine = Medicine::where('nama', 'like', '%'.trim($request->nama).'%')->paginate(15);
        
        return view('pages.medicine.index')
            ->with('medicines', $medicine);
    }

    public function export()
    {
        $medicine = Medicine::get(['id', 'nama']);

        return response()->json($medicine);
    }
}
