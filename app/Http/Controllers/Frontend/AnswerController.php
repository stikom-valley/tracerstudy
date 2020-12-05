<?php

namespace App\Http\Controllers\Frontend;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answer = Answer::all();
        $question = Question::all();
        return view('', ['answer' => $answer, 'question' => $question]);
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

        $answer = new Answer();

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
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $question = Question::findOrFail($request->get('id'));
        $answer = Answer::find($id);
        $answer->description = $request->get('description');
        $answer->question_id = $question->id;
        $answer->save();
        return redirect() -> route('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $answer = Answer::findOrFail($id);
       $answer->delete();
       return redirect() -> route('');
    }
}
