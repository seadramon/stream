<?php

namespace Streamcms\Http\Controllers;

use Illuminate\Http\Request;

use Streamcms\Models\Tvradios;
use Streamcms\Http\Requests\TvradioRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DB;
use Html;
use Validator;
use Redirect;
use Session;

class TvradioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tvradios::paginate(20);
        
        return view('pages.tvradio.index')
            ->with('data', $data);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tvradio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TvradioRequest $request)
    {
        DB::beginTransaction();

        try {
            $file = $request->file('image');
            $filename = null;

            if ($file!=null) {
                $filename = $this->upload($file, 'logo');
            }

            $data = Tvradios::create([
                'key' => $request->key,
                'name' => $request->name,
                'stream' => $request->stream,
                'image' => $filename,
                'bgcolor' => $request->bgcolor,
                'position' => $request->position,
                'channel' => $request->channel,
                'status' => $request->status,
            ]);

            DB::commit();

            Session::flash('success', 'Successfully created row!');
            return Redirect::to('tvradio');
        } catch(Exception $e) {
            DB::rollback();
            Session::flash('failed', 'Failed! '.$e->getMessage());

            return redirect::route('tvradio.create');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tvradio = Tvradios::find($id);

        return view('pages.tvradio.create')
            ->with('tvradio', $tvradio)
            ->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TvradioRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = Tvradios::find($id);

            $file = $request->file('image');
            $filename = null;

            if ($file!=null) {
                $filename = $this->upload($file, 'logo');
                $data->image = $filename;
            }

            $data->key = $request->key;
            $data->name = $request->name;
            $data->stream = $request->stream;
            $data->bgcolor = $request->bgcolor;
            $data->position = $request->position;
            $data->channel = $request->channel;
            $data->status = $request->status;
            $data->update();

            DB::commit();

            Session::flash('success', 'Successfully updated row!');
            return Redirect::to('tvradio');
        } catch(Exception $e) {
            DB::rollback();
            Session::flash('failed', 'Failed! '.$e->getMessage());

            return redirect::route('tvradio.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Tvradios::find($id);
        $data->delete();

        // redirect
        Session::flash('success', 'Successfully deleted the row!');
        return Redirect::to('tvradio');
    }

    private function upload($file = null, $directory = null, $name = null) {
        if (null !== $file) {
            $extension = $file->getClientOriginalExtension();
            $filenya = $file->getClientOriginalName();
            
            // save document
            if (null == $name) {
                $name = str_random(4) . $file->getFilename();
            }
            
            $filename = $name . '.' . $extension;
            $test = Storage::disk('public')->put($filename,  File::get($file));

            return $filename;
        }
        return null;
    }

    public function export(Request $request)
    {
        $data = Tvradios::select('id', 'key', 'name', 'stream', 'image', 'bgcolor as background color', 'channel');

        if ($request->channel != 'all') {
            $data->where('channel', $request->channel);
        }

        $data = $data->get();

        return response()
            ->json($data->toJson(JSON_PRETTY_PRINT));
    }

    public function play($id)
    {
        $data = Tvradios::find($id);

        return view('pages.tvradio.play')
            ->with('data', $data);
    }
}
