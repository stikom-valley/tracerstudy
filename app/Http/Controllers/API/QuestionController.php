<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Question;
use App\Choice;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'type_question' => 'required',
            'type_answer' => 'required'
        ];

        $ruleMessages = [
            'type_question.required' => 'Tipe Pertanyaan harus diisi',
            'type_answer.required' => 'Tipe Jawaban harus diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $ruleMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all()
            ]);
        }

        $question = Question::where('type_question', $request->get('type_question'))->where('type_answer', $request->get('type_answer'))->get();

        $arr = [];
        $data = [];

        foreach ($question as $row) {
            $y['question_id'] = $row->id;
            $y['description'] = $row->description;
            $y['type_answer'] = $row->type_answer;
            $y['type_question'] = $row->type_question;
            if ($request->get('type_answer') == 'CHOICE') {
                $choice = Choice::where('question_id', $row->id)->get();
                foreach ($choice as $rowchoice) {
                    $x['choice_id'] = $rowchoice->id;
                    $x['answer_choice'] = $rowchoice->description;
                    array_push($arr, $x);
                }
                $y['answer'] = $arr;
            }
            array_push($data, $y);
        }


        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $data
        ]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
