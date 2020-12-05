<?php

namespace App\Http\Controllers\Frontend;

use App\Major;
use App\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::all();
        return view('frontend.dashboard.faculties.index', ['faculties' => $faculties]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.dashboard.faculties.create');
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
            'name' => 'required|min:3',
        ];

        $ruleMessages = [
            'name.required' => 'Nama Fakultas harus diisi',
            'name.min' => 'Nama Fakultas minimal 3 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $htmlErrors = '<ul>';

            foreach ($errors as $item) {
                $htmlErrors .= '<li>' . $item . '</li>';
            }

            $htmlErrors .= '</ul>';

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => false,
                'error' => $validator->errors()->all(),
                'message' => '<div class="alert alert-danger">Mohon masukkan data yang sesuai dengan formulir:<br>' . $htmlErrors . '</div>'
            ]);
        }

        $name = $request->name;

        $faculty = new Faculty();

        $faculty->name = $name;
        $faculty->slug = Str::slug($name);

        $faculty->save();

        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            'message' => '<div class="alert alert-success">Data berhasil ditambahkan</div>'
        ]);
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
        $faculty = Faculty::findOrFail($id);
        $majors = Major::where('faculty_id', $id)->get();

        return view('frontend.dashboard.faculties.edit', ['faculty' => $faculty, 'majors' => $majors]);
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
            'name' => 'required|min:3'
        ];

        $ruleMessages = [
            'name.required' => 'Nama Fakultas harus diisi',
            'name.min' => 'Nama Fakultas minimal 3 karakter',
        ];

        $this->validate($request, $rules, $ruleMessages);

        $name = $request->name;

        $faculty = Faculty::findOrFail($id);

        $faculty->name = $name;
        $faculty->slug = Str::slug($name);

        $faculty->save();

        return redirect()->route('faculty.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();
        return redirect()->route('faculty.index');
    }
}
