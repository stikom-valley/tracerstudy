<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Education;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'entry_year' => 'required',
            'graduation_year' => 'required',
            'description' => 'required',
            'score'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $educ = new Education();
        $educ->entry_year = date("Y",strtotime($request->get('entry_year')));
        $educ->graduation_year = date("Y",strtotime($request->get('graduation_year')));
        $educ->score = $request->get('score');
        $educ->faculty_id = $request->get('faculty_id');
        $educ->major_id = $request->get('major_id');
        $educ->user_id = $request->get('user_id');
        $educ->save();
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
            'entry_year' => 'required',
            'graduation_year' => 'required',
            'description' => 'required',
            'score'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $educ = Education::findOrFail($id);
        $educ->entry_year = date("Y",strtotime($request->get('entry_year')));
        $educ->graduation_year = date("Y",strtotime($request->get('graduation_year')));
        $educ->score = $request->get('score');
        $educ->faculty_id = $request->get('faculty_id');
        $educ->major_id = $request->get('major_id');
        $educ->user_id = $request->get('user_id');
        $educ->save();
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
        $educ = Education::findOrFail($id);
        $educ->delete();
        return redirect()->route('');
    }
}
