<?php

namespace App\Http\Controllers\Frontend;

use App\Major;
use App\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $major = Major::all();
        $faculty = Faculty::all();
        return view('', ['major' => $major, 'faculty' => $faculty]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('');
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
            'name.required' => 'Nama Jurusan harus diisi',
            'name.min' => 'Nama Jurusan minimal 3 karakter',
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

        $idFaculty = $request->faculty_id;
        $name = $request->name;

        $major = new Major();

        $major->faculty_id = $idFaculty;
        $major->name = $name;
        $major->slug = Str::slug($name);

        $major->save();

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
        $major = Major::findOrFail($id);
        $faculty = Faculty::all();
        return view('', ['major' => $major, 'faculty' => $faculty]);
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
            'name' => 'required',
            'slug' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $faculty = Faculty::findOrFail($request->get('id'));
        $major = Major::findOrFail($id);
        $major->name = $request->get('name');
        $major->slug = $request->get('slug');
        $major->faculties_id = $faculty->get('id');
        $major->save();
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
        $major = Major::findOrFail($id);
        $major->delete();
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Jurusan berhasil dihapus',
        ]);
    }
}
