<?php

namespace Streamcms\Http\Controllers;

use Streamcms\Models\Info;
use Streamcms\Models\Keyword;

use Illuminate\Http\Request;

use Html;
use Validator;
use Redirect;
use Session;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Info::paginate(15);

        return view('pages.info.index')
            ->with('infos', $info);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keyword = Keyword::get()->pluck('nama', 'id');

        return view('pages.info.create')
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
            return Redirect::to('info/create')
                ->withErrors($validator);
        } else {
            $data = Info::create($request->except('keyword'));

            $keywords = $request['keyword'];
            if (is_array($keywords) && count($keywords) > 0) {
                foreach ($keywords as $keyword) {
                    $data->assignKeyword($keyword);    
                }
            }

            Session::flash('message', 'Successfully created info!');
            return Redirect::to('info');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Streamcms\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(Info $info)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Streamcms\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Info::find($id);
        $keyword = Keyword::get()->pluck('nama', 'id');

        return view('pages.info.create')
            ->with('keyword', $keyword)
            ->with('info', $info)
            ->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Streamcms\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return Redirect::to('info/create')
                ->withErrors($validator);
        } else {
            $data = Info::find($id);
            $data->update($request->except('keyword'));

            $keywords = $request['keyword'];
            if (is_array($keywords) && count($keywords) > 0) {
                $data->revokeKeyword();
                $data->keyword()->attach($keywords);  
            }

            Session::flash('message', 'Successfully updated info!');
            return Redirect::to('info');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Streamcms\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = Info::find($id);
        $info->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the info!');
        return Redirect::to('info');
    }

    public function search(Request $request)
    {
        $info = Info::where('nama', 'like', '%'.trim($request->nama).'%')->paginate(15);
        
        return view('pages.info.index')
            ->with('infos', $info);
    }

    public function export()
    {
        $info = Info::get(['id', 'nama']);

        return response()->json($info);
    }
}
