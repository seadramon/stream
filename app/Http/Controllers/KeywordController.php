<?php

namespace Streamcms\Http\Controllers;

use Streamcms\Models\Keyword;
use Streamcms\Models\Medicine;
use Streamcms\Models\Info;

use Illuminate\Http\Request;

use Illuminate\Contracts\Routing\ResponseFactory;

use Html;
use Validator;
use Redirect;
use Session;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Keyword::paginate(15);

        return view('pages.keyword.index')
            ->with('keywords', $keyword);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $medicine = Medicine::get()->pluck('nama', 'id');
        $info = Info::get()->pluck('nama', 'id');

        return view('pages.keyword.create')
            ->with('medicine', $medicine)
            ->with('info', $info);
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
            return Redirect::to('keyword/create')
                ->withErrors($validator);
        } else {
            $data = Keyword::create($request->except('medicine', 'info'));

            $medicines = $request['medicine'];
            if (is_array($medicines) && count($medicines) > 0) {
                foreach ($medicines as $medicine) {
                    $data->assignMedicine($medicine);    
                }
            }

            $infos = $request['medicine'];
            if (is_array($infos) && count($infos) > 0) {
                foreach ($infos as $info) {
                    $data->assignInfo($info);    
                }
            }

            Session::flash('message', 'Successfully created keyword!');
            return Redirect::to('keyword');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Streamcms\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function show(Keyword $keyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Streamcms\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keyword = Keyword::find($id);
        $medicine = Medicine::get()->pluck('nama', 'id');
        $info = Info::get()->pluck('nama', 'id');

        return view('pages.keyword.create')
            ->with('keyword', $keyword)
            ->with('medicine', $medicine)
            ->with('info', $info)
            ->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Streamcms\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return Redirect::to('keyword/create')
                ->withErrors($validator);
        } else {
            $data = Keyword::find($id);
            $data->update($request->except('medicine', 'info'));

            $medicines = $request['medicine'];
            if (is_array($medicines) && count($medicines) > 0) {
                $data->revokeMedicine();
                $data->medicine()->attach($medicines);  
            }

            $infos = $request['info'];
            if (is_array($infos) && count($infos) > 0) {
                $data->revokeInfo();
                $data->info()->attach($infos);  
            }

            Session::flash('message', 'Successfully updated keyword!');
            return Redirect::to('keyword');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Streamcms\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nerd = Keyword::find($id);
        $nerd->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the keyword!');
        return Redirect::to('keyword');
    }

    public function search(Request $request)
    {
        $keyword = Keyword::where('nama', 'like', '%'.trim($request->nama).'%')->paginate(15);
        
        return view('pages.keyword.index')
            ->with('keywords', $keyword);
    }

    public function export()
    {
        $keyword = Keyword::get(['id', 'nama']);

        return response()->json($keyword);
    }
}
