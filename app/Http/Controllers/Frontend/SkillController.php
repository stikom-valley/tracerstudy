<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::select('id', 'name', DB::raw('COUNT(user_id) as total_user'))
            ->groupBy('name')
            ->get();

        return view('frontend.dashboard.competence.index')
            ->with(['skills' => $skills]);
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
}
