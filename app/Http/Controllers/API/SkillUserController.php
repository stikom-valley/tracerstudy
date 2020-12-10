<?php

namespace App\Http\Controllers\API;

use App\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkillUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser = auth()->user()->id;

        $skills = Skill::where('user_id', $idUser)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $skills,
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
            'name' => 'required|min:3',
            'certification_document' => 'nullable|mimes:pdf|max:2048',
        ];

        $ruleMessages = [
            'name.required' => 'Nama Keahlian harus diisi',
            'name.min' => 'Nama Keahlian minimal 3 karakter',
            'certification_document.mimes' => 'Format dokumen harus .PDF',
            'certification_document.max' => 'Ukuran maksimum 2MB',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        $idUser = auth()->user()->id;

        $filePath = 'public/uploads/certification/';

        $storagePath = Storage::put($filePath, $request->certification_document);

        $fileName = basename($storagePath);

        DB::beginTransaction();

        try {

            $skill = new Skill();

            $skill->user_id = $idUser;
            $skill->name = $request->name;
            $skill->certification_document = $fileName;

            $skill->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Keahlian berhasil ditambahkan',
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
        $skill = Skill::findOrFail($id);

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_FOUND,
            'data' => $skill,
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
            'name' => 'required|min:3',
            'certification_document' => 'nullable|mimes:pdf|max:2048',
        ];

        $ruleMessages = [
            'name.required' => 'Nama Keahlian harus diisi',
            'name.min' => 'Nama Keahlian minimal 3 karakter',
            'certification_document.mimes' => 'Format dokumen harus .PDF',
            'certification_document.max' => 'Ukuran maksimum 2MB',
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        $skill = Skill::findOrFail($id);

        $filePath = 'public/uploads/certification/';

        if ($request->certification_document) {

            $storagePath = Storage::put($filePath, $request->certification_document);
            $fileName = basename($storagePath);

            if ($fileName != $skill->certification_document) {

                Storage::delete($filePath . $skill->certification_document);
            }
        } else {

            $fileName = $skill->certification_document;
        }

        DB::beginTransaction();

        try {

            $skill->name = $request->name;
            $skill->certification_document = $fileName;

            $skill->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_CREATED,
                'message' => 'Keahlian berhasil diperbarui',
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
        $skill = Skill::findOrFail($id);

        $filePath = 'public/uploads/certification/';

        Storage::delete($filePath, $skill->certification_document);

        $skill->delete();

        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'message' => 'Keahlian berhasil dihapus',
        ]);
    }
}
