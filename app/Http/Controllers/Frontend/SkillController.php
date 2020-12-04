<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Skill;
use Illuminate\Support\Facades\Validator;
use App\User;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('role_id', 3)->get();
        return view('frontend.dashboard.competence.index', ['users' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('role_id', 3)->get();
        return view('frontend.dashboard.competence.create', ['users' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'pilih_alumni' => 'required',
            'nama_kompetensi' => 'required',
            'sertifikat' => 'nullable'
        ];

        $ruleMessages = [
            'pilih_alumni.required' => 'Alumni harus diisi',
            'nama_kompetensi' => 'nama kompetensi harus diisi'
        ];

        $this->validate($request, $rules, $ruleMessages);
        $skill = new Skill();
        $skill->name = $request->get('nama_kompetensi');
        $skill->certification_document = $request->get('sertifikat');
        $skill->user_id = $request->get('pilih_alumni');
        $skill->save();
        return redirect()->route('competence.index')->with('success', 'Kompetensi berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $skill = Skill::where('user_id', $id)->get();
        return view('frontend.dashboard.competence.show', ['user' => $user, 'skills' => $skill]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $user = User::findOrFail($skill->user_id);
        return response()->json(['skill' => $skill, 'user' => $user]);
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

        $rules = [
            'nama_kompetensi' => 'required',
            'sertifikat' => 'nullable'
        ];

        $ruleMessages = [
            'nama_kompetensi' => 'nama kompetensi harus diisi'
        ];

        $this->validate($request, $rules, $ruleMessages);
        $skill = Skill::findOrFail($id);
        $skill->name = $request->get('nama_kompetensi');
        $skill->certification_document = $request->get('sertifikat');
        $skill->save();
        return redirect()->route('competence.show',[$skill->user_id])->with('success', 'Kompetensi berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return response()->json(['message'=>'sukses']);
    }
}
