<?php

namespace App\Http\Controllers\Frontend;

use App\Choice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChoiceController extends Controller
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
        $rules = [
            'description' => 'required|min:3',
        ];

        $ruleMessages = [
            'description.required' => 'Deskripsi Jawaban harus diisi',
            'description.min' => 'Deskripsi Jawaban minimal 3 karakter',
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

        $idQuestion = $request->question_id;
        $description = $request->description;

        $answer = new Choice();

        $answer->question_id = $idQuestion;
        $answer->description = $description;

        $answer->save();

        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            'message' => '<div class="alert alert-success">Data berhasil ditambahkan</div>'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function show(Choice $choice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function edit(Choice $choice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Choice $choice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $choicedel = Choice::findOrFail($id)->delete();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => true,
                'message' => 'Jawaban Pilihan berhasil dihapus'
            ]);
        }
    }

    public function deleteAllChoice(Request $request, $id){
        if($request->ajax()){
            $choice = Choice::where('question_id', $id)->delete();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => true,
                'message' => 'Jawaban Pilihan berhasil dihapus'
            ]);

        }
    }
}
