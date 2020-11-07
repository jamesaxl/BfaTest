<?php

namespace App\Http\Controllers\Api;

use App\Model\QuestionAnswer;
use Illuminate\Http\Request;
use App\Http\DataGrids\QuestionAnswerDataGrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAnswerStore;
use App\Http\Requests\QuestionAnswerUpdate;

class QuestionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions_answers = QuestionAnswer::with('country',
             'sector', 'subSector')->paginate(30);
        return response()->json($questions_answers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(QuestionAnswerDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionAnswerStore $request)
    {
        $question_answer = QuestionAnswer::create(
            $request->all()
        );

        if ($request->hasFile('document')) {
            $file = $request->file('document')->store('storage/question_answer_document');
            $question_answer->document = $file;
            $question_answer->save();
        }

        return response()->json([
            'error' => 0,
            'message' => 'question_answer has been registered',
            'data' => $question_answer,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Sector  $question_answer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question_answer = QuestionAnswer::with('country',
            'sector', 'subSector')->where('id', $id)->first();

        if (!$question_answer) {
            return response()->json([
                'error' => 1,
                'message' => 'question_answer with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $question_answer ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param QuestionAnswerUpdate $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionAnswerUpdate $request, $id)
    {
        $question_answer = QuestionAnswer::find($id);

        if (!$question_answer) {
            return response()->json([
                'error' => 1,
                'message' => 'question_answer with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $question_answer->fill($request->all())->save();

        if ($updated) {

            if ($request->hasFile('document')) {
                $file = $request->file('document')->store('storage/question_answer_document');
                $question_answer->document = $file;
                $question_answer->save();
            }
            
            return response()->json([
                'error' => 0,
                'message' => 'question_answer has been updated',
                'data' => $question_answer,
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'message' => 'question_answer could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Sector  $question_answer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question_answer = QuestionAnswer::find($id);

        if (!$question_answer) {
            return response()->json([
                'error' => 1,
                'message' => 'question_answer with id ' . $id . ' not found'
            ], 400);
        }

        $question_answer->delete();
        return response()->json([
            'error' => 0,
            'message' => 'question_answer has been deleted'
        ]);
    }
}
