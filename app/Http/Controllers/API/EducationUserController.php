<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Education;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Major;
use App\Faculty;
use Illuminate\Support\Facades\Validator;

class EducationUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser = auth()->user()->id;
        $education = Education::where('user_id', $idUser->id)->latest()->get();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $education
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'entry_year' => 'required|integer|min:' . date('Y'),
            'graduation_year' => 'required|integer|min:' . date('Y'),
            'score' => 'required|between:0,4',
            'faculty_id' => 'required',
            'major_id' => 'required'
        ];

        $ruleMessages = [
            'entry_year.required' => 'Tahun masuk harus diisi',
            'entry_year.integer' => 'Tahun masuk harus integer',
            'entry_year.min' => 'Tahun masuk minimal',
            'graduation_year.required' => 'Tahun lulus harus diisi',
            'graduation_year.integer' => 'Tahun lulus harus integer',
            'graduation_year.min' => 'Tahun lulus minimal',
            'score.required' => 'IPK harus diisi',
            'score.between' => 'IPK harus diantara 0 sampai 4',
            'faculty_id.required' => 'id fakultas harus diisi',
            'major_id.required' => 'id jurusan harus diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all()
            ]);
        }

        $idUser = auth()->user()->id;

        DB::beginTransaction();

        try {
            $education = new Education();
            $education->entry_year = $request->get('entry_year');
            $education->graduation_year = $request->get('graduation_year');
            $education->score = $request->get('score');
            $major = Major::findOrFail($request->get('major_id'));
            $education->major_id = $major->id;
            $faculty = Faculty::findOrFail($request->get('faculty_id'));
            $education = $faculty->id;
            $education->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Data Pendidikan berhadil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_ACCEPTABLE,
                'message' => 'Ada yang salah!',
            ]);
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
        $education = Education::findOrFail($id);

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_FOUND,
            'data' => $education
        ]);
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
        $rules = [
            'entry_year' => 'required|integer|min:' . date('Y'),
            'graduation_year' => 'required|integer|min:' . date('Y'),
            'score' => 'required|between:0,4',
            'faculty_id' => 'required',
            'major_id' => 'required'
        ];

        $ruleMessages = [
            'entry_year.required' => 'Tahun masuk harus diisi',
            'entry_year.integer' => 'Tahun masuk harus integer',
            'entry_year.min' => 'Tahun masuk minimal',
            'graduation_year.required' => 'Tahun lulus harus diisi',
            'graduation_year.integer' => 'Tahun lulus harus integer',
            'graduation_year.min' => 'Tahun lulus minimal',
            'score.required' => 'IPK harus diisi',
            'score.between' => 'IPK harus diantara 0 sampai 4',
            'faculty_id.required' => 'id fakultas harus diisi',
            'major_id.required' => 'id jurusan harus diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all()
            ]);
        }

        $idUser = auth()->user()->id;

        DB::beginTransaction();

        try {
            $education = Education::findOrFail($id);
            $education->entry_year = $request->get('entry_year');
            $education->graduation_year = $request->get('graduation_year');
            $education->score = $request->get('score');
            $major = Major::findOrFail($request->get('major_id'));
            $education->major_id = $major->id;
            $faculty = Faculty::findOrFail($request->get('faculty_id'));
            $education = $faculty->id;
            $education->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Data Pendidikan berhadil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_ACCEPTABLE,
                'message' => 'Ada yang salah!',
            ]);
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
        $education = Education::findOrFail($id);
        $education->save();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Data Pendidikan berhasil dihapus'
        ]);
    }
}
