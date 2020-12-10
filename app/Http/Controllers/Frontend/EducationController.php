<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Major;
use App\Faculty;
use App\Education;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educations = Education::select('graduation_year', DB::raw('COUNT(user_id) as total_user'))
            ->groupBy('graduation_year')
            ->orderBy('graduation_year', 'asc')
            ->get();

        return view('frontend.dashboard.educations.index')
            ->with(['educations' => $educations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role_id', 3)
            ->whereDoesntHave('education')
            ->get();

        $faculties = Faculty::all();

        return view('frontend.dashboard.educations.create')
            ->with([
                'users' => $users,
                'faculties' => $faculties,
            ]);
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
            'user_id' => 'required',
            'faculty_id' => 'required',
            'major_id' => 'required',
            'daterange' => 'required',
            'score' => 'required',
        ];

        $ruleMessages = [
            'user_id.required' => 'Alumni harus dipilih',
            'faculty_id.required' => 'Fakultas harus dipilih',
            'major_id.required' => 'Jurusan harus dipilih',
            'daterange.required' => 'Tahun kelulusan harus dipilih',
            'score.required' => 'IPK harus diisi',
        ];

        $this->validate($request, $rules, $ruleMessages);

        $date = explode('-', $request->daterange);
        $entryYear = date('Y', strtotime($date[0]));
        $graduationYear = date('Y', strtotime($date[1]));

        $education = new Education();

        $education->entry_year = $entryYear;
        $education->graduation_year = $graduationYear;
        $education->score = $request->score;
        $education->faculty_id = $request->faculty_id;
        $education->major_id = $request->major_id;
        $education->user_id = $request->user_id;

        $education->save();

        return redirect()
            ->route('education.index')
            ->with('success', 'Data kelulusan berhasil ditambahkan');
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

        $faculties = Faculty::all();

        return view('frontend.dashboard.educations.edit')
            ->with([
                'faculties' => $faculties,
            ]);
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
            'user_id' => 'required',
            'faculty_id' => 'required',
            'major_id' => 'required',
            'daterange' => 'required',
            'score' => 'required',
        ];

        $ruleMessages = [
            'user_id.required' => 'Alumni harus dipilih',
            'faculty_id.required' => 'Fakultas harus dipilih',
            'major_id.required' => 'Jurusan harus dipilih',
            'daterange.required' => 'Tahun kelulusan harus dipilih',
            'score.required' => 'IPK harus diisi',
        ];

        $this->validate($request, $rules, $ruleMessages);

        $date = explode('-', $request->daterange);
        $entryYear = date('Y', strtotime($date[0]));
        $graduationYear = date('Y', strtotime($date[1]));

        $education = Education::findOrFail($id);

        $education->entry_year = $entryYear;
        $education->graduation_year = $graduationYear;
        $education->score = $request->score;
        $education->faculty_id = $request->faculty_id;
        $education->major_id = $request->major_id;
        $education->user_id = $request->user_id;

        $education->save();

        return redirect()
            ->route('education.index')
            ->with('success', 'Data kelulusan berhasil diperbarui');
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
        return redirect()
            ->route('education.index')
            ->with('success', 'Data kelulusan berhasil dihapus');
    }

    public function getMajors(Request $request)
    {
        $idFaculty = $request->faculty_id;

        $data = Major::where('faculty_id', $idFaculty)
            ->select('id', 'name')
            ->get();

        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            'data' => $data,
        ]);
    }
}
