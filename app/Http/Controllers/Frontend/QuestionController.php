<?php

namespace App\Http\Controllers\Frontend;

use App\Choice;
use App\Question;
use App\AnswerUser;
use App\AnswerEssay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        $questionEssays = Question::where('type_question', 'GENERAL')->get();

        return view('frontend.dashboard.questions.index')
            ->with([
                'questions' => $questions,
                'questionEssays' => $questionEssays,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.dashboard.questions.create');
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
            'type_questions' => 'required',
            'type_answers' => 'required_if:type_questions,GENERAL',
            'description' => 'required|min:10',
            // 'type_answers.*' => 'required|string|min:5',

        ];

        $ruleMessages = [
            'type_questions.required' => 'Tipe Pertanyaan harus dipilih',
            'type_answers.required_if' => 'Tipe Jawaban harus dipilih',
            'description.required' => 'Pertanyaan harus diisi',
            'description.min' => 'Pertanyaan minimal 10 karakter',
        ];

        $this->validate($request, $rules, $ruleMessages);

        $sequence = Question::where('type_question', 'GENERAL')
            ->count();

        $sequence += 1;

        $question = new Question();

        $question->description = $request->description;
        $question->type_question = $request->type_questions;
        $question->type_answer = ($request->type_questions) == 'BOT' ? 'ESSAY' : $request->type_answers;
        $question->sequence = ($request->type_questions) == 'BOT' ? null : $sequence;
        $question->save();
        if ($request->type_answers == 'CHOICE') {
            $datadesc = $request->description_choice;
            foreach ($datadesc as $row) {
                $choice = new Choice();
                $choice->description = strip_tags($row);
                $choice->question_id = $question->id;
                $choice->save();
            }
        }

        return redirect()
            ->route('question.index')
            ->with('success', 'Pertanyaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        $choice = Choice::where('question_id', $id)->get();

        return view('frontend.dashboard.questions.show', ['question' => $question, 'choice' => $choice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        $choices = Choice::where('question_id', $id)
            ->get();

        return view('frontend.dashboard.questions.edit')
            ->with([
                'question' => $question,
                'choices' => $choices,
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
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $faculty = Question::findOrFail($id);
        $faculty->description = $request->get('description');
        $faculty->save();
        return redirect()->route('question.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $question = Question::findOrFail($id);
            $choice = Choice::where('question_id', $id)->count();
            $answeressay = AnswerEssay::where('question_id', $id)->count();
            $data = '';
            if ($choice > 0 || $answeressay > 0) {
                $data = 'Maaf, tidak bisa menghapus pertanyaan ini';
                $message = [
                    'status' => false,
                    'message' => $data
                ];
            } else {
                $question->delete();
                $data = 'Pertanyaan berhasil dihapus';
                $message = [
                    'status' => true,
                    'message' => $data
                ];
            }
            return response()->json($message);
        }
    }

    public function sort(Request $request)
    {
        $sequence = 1;

        $seq = $request->sequence;

        foreach ($seq as $key) {
            DB::beginTransaction();

            try {
                $id = $key['id'];

                $link =  Question::find($id);

                $link->sequence = $sequence++;

                $link->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);
            }
        }
    }
}
