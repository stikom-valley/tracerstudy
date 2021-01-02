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
        if ($request->get('type_answer') == 'CHOICE') {
            //push answer by question id
            foreach ($question as $row) {
                $choice = Choice::where('question_id', $row->id)->get();
                foreach ($choice as $rowchoice) {
                    $x['choice_id'] = $rowchoice->id;
                    $x['question_id'] = $rowchoice->question_id;
                    $x['answer_choice'] = $rowchoice->description;
                    array_push($arr, $x);
                }
            }
            //group array by question id
            $result = array();
            foreach ($arr as $key => $element) {
                $result[$element['question_id']][] = $element;
            }
            //menggabungkan 2 array, answer and question
            foreach ($result as $key => $rowvalue) {
                foreach ($question as $keyq => $datavalue) {
                    if ($key == $datavalue->id) {
                        $y['question_id'] = $datavalue->id;
                        $y['description'] = $datavalue->description;
                        $y['type_answer'] = $datavalue->type_answer;
                        $y['type_question'] = $datavalue->type_question;
                        $y['sequence'] = $datavalue->sequence;
                        $y['created_at'] = $datavalue->created_at;
                        $y['updated_at'] = $datavalue->updated_at;
                        $y['answer'] = $result[$key];
                        array_push($data, $y);
                    }
                }
            }
        } elseif ($request->get('type_answer') == 'ESSAY') {
            $data = Question::where('type_question', $request->get('type_question'))->where('type_answer', $request->get('type_answer'))->get();
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
