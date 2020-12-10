<?php

namespace App\Http\Controllers\API;

use App\Experience;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExperienceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser = auth()->user()->id;

        $experiences = Experience::where('user_id', $idUser)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $experiences,
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
            'company_name' => 'required|min:3',
            'job_title' => 'required|min:3',
            'start_date' => 'required',
            'description' => 'nullable|min:10',
            'location' => 'required|min:10'
        ];

        $ruleMessages = [
            'company_name.required' => 'Nama Perusahaan harus diisi',
            'company_name.min' => 'Nama Perusahaan minimal 3 karakter',
            'job_title.required' => 'Jabatan harus diisi',
            'job_title.min' => 'Jabatan minimal 3 karakter',
            'start_date.required' => 'Tanggal mulai bekerja harus diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'location.min' => 'Lokasi minimal 10 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator,
            ]);
        }

        $idUser = auth()->user()->id;

        DB::beginTransaction();

        try {

            $experiences = new Experience();

            $experiences->user_id = $idUser;
            $experiences->company_name = $request->company_name;
            $experiences->job_title = $request->job_title;
            $experiences->start_date = date('Y-m-d', strtotime($request->start_date));
            $experiences->end_date = date('Y-m-d', strtotime($request->end_date));
            $experiences->is_present = $request->is_present;
            $experiences->description = $request->description;
            $experiences->location = $request->location;

            $experiences->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Riwayat Pekerjaan berhasil ditambahkan',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_ACCEPTABLE,
                'message' => 'Auch, ada yang salah!',
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
        $experience = Experience::findOrFail($id);

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_FOUND,
            'data' => $experience,
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
            'company_name' => 'required|min:3',
            'job_title' => 'required|min:3',
            'start_date' => 'required',
            'description' => 'nullable|min:10',
            'location' => 'required|min:10'
        ];

        $ruleMessages = [
            'company_name.required' => 'Nama Perusahaan harus diisi',
            'company_name.min' => 'Nama Perusahaan minimal 3 karakter',
            'job_title.required' => 'Jabatan harus diisi',
            'job_title.min' => 'Jabatan minimal 3 karakter',
            'start_date.required' => 'Tanggal mulai bekerja harus diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'location.min' => 'Lokasi minimal 10 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator,
            ]);
        }

        DB::beginTransaction();

        try {

            $experiences = Experience::findOrfail($id);

            $experiences->company_name = $request->company_name;
            $experiences->job_title = $request->job_title;
            $experiences->start_date = date('Y-m-d', strtotime($request->start_date));
            $experiences->end_date = date('Y-m-d', strtotime($request->end_date));
            $experiences->is_present = $request->is_present;
            $experiences->description = $request->description;
            $experiences->location = $request->location;

            $experiences->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Riwayat Pekerjaan berhasil diperbarui',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_NOT_ACCEPTABLE,
                'message' => 'Auch, ada yang salah!',
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
        $experience = Experience::findOrFail($id);

        $experience->delete();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Riwayat Pekerjaan berhasil dihapus',
        ]);
    }
}
