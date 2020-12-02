<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Experience;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exper = Experience::all();
        return view('', ['exper' => $exper]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'location' => 'required',
            'is_present'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $exper = new Experience();
        $exper->company_name = $request->get('company_name');
        $exper->job_title = $request->get('job_title');
        $exper->start_date = date("d/m/Y",strtotime($request->get('start_date')));
        $exper->end_date = date("d/m/Y",strtotime($request->get('end_date')));
        $exper->is_present = $request->get('is_present');
        $exper->description = $request->get('description');
        $exper->location = $request->get('location');
        $exper->user_id = $request->get('user_id');
        $exper->save();
        return redirect()->route('');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'location' => 'required',
            'is_present'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $exper = Experience::findOrFail($id);
        $exper->company_name = $request->get('company_name');
        $exper->job_title = $request->get('slug');
        $exper->start_date = date("d/m/Y",strtotime($request->get('start_date')));
        $exper->end_date = date("d/m/Y",strtotime($request->get('end_date')));
        $exper->is_present = $request->get('is_present');
        $exper->description = $request->get('description');
        $exper->location = $request->get('location');
        $exper->user_id = $request->get('user_id');
        $exper->save();
        return redirect()->route('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exper = Experience::findOrFail($id);
        $exper->delete();
    }
}
