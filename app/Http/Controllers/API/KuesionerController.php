<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\AnswerUser;
use App\AnswerEssay;
use App\Choice;
use Illuminate\Support\Facades\Validator;

class KuesionerController extends Controller
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
            'data' => 'required'
        ];
        $ruleMessages = [
            'data.required' => 'data array json harus diisi'
        ];
        $validator = Validator::make($request->all(), $rules, $ruleMessages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all()
            ]);
        }
        $data = $request->get('data');
        $datakuesioner = json_decode($data, true);
        foreach ($datakuesioner as $data) {
            if (strtoupper($data['type_answer']) == 'CHOICE' && $data['choice_id'] != "") {
                $answerUser = new AnswerUser();
                $answerUser->user_id = $data['user_id'];
                $answerUser->choice_id = $data['choice_id'];
                $answerUser->save();
            } else {
                $essay = new AnswerEssay();
                $essay->description = $data['answer'];
                $essay->question_id = $data['question_id'];
                $essay->save();
                $answerUser = new AnswerUser();
                $answerUser->user_id = $data['user_id'];
                $answerUser->answer_essay_id = $essay->id;
                $answerUser->save();
            }
        }
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => 'Kuesioner berhasil di submit'
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
