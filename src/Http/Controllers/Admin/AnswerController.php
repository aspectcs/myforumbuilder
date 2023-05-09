<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Answer;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AnswerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Question $question)
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.question.answer.create', $question->encrypt_id),
                'breadcrumb' => [
                    'heading' => 'Answers',
                    'chunks' => [
                        'Dashboard',
                        'Question',
                        'Answers',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.question.answer.json', $question->encrypt_id),
                'dtHeading' => 'Answers',
                'dtInfo' => [
                    "labels" => [
                        [
                            "title" => "Sno",
                            "className" => "text-center",
                            "data" => "DT_RowIndex",
                            "sortable" => false,
                            "searchable" => false
                        ],
                        [
                            "title" => "Answers",
                            "data" => "answer",
                        ],
                        [
                            "title" => "Status",
                            "className" => "text-center",
                            "data" => "status",
                            "sortable" => false,
                            "searchable" => false
                        ],
                        [
                            "title" => "Created at",
                            "data" => "created_at",
                        ],
                        [
                            "title" => "Updated at",
                            "data" => "updated_at",
                        ],
                        [
                            "title" => "Action",
                            "className" => "text-center",
                            "data" => "action",
                            "sortable" => false,
                            "searchable" => false
                        ]
                    ],
                    "order" => [
                        [
                            0,
                            "desc"
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Display a JSON listing of the resource.
     */
    public function json(Question $question)
    {
        $query = $question->answers()->select(
            [
                'id',
                'answer',
                'status',
                'created_at',
                'updated_at'
            ]
        )->orderBy('id', 'DESC');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('answer', function (Answer $answer) {
                return Str::words($answer->answer, 10);
            })
            ->filterColumn('answer', function ($query, $keyword) {
                $query->where('answer', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('status', function (Answer $answer) use ($question) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $answer->status,
                    'updateUrl' => route('admin.question.answer.status', [
                        'question' => $question->encrypt_id,
                        'answer' => $answer->encrypt_id
                    ]),
                ]);
            })
            ->addColumn('action', function (Answer $answer) use ($question) {
                return view('MyForumBuilder::admin.common.action', [
                    'edit' => route('admin.question.answer.edit', [
                        'question' => $question->encrypt_id,
                        'answer' => $answer->encrypt_id
                    ]),
                    'delete' => route('admin.question.answer.destroy', [
                        'question' => $question->encrypt_id,
                        'answer' => $answer->encrypt_id
                    ])
                ]);
            })
            ->addColumn('created_at', function (Answer $answer) {
                return $answer->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (Answer $answer) {
                return $answer->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action', 'answer'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(Question $question, Answer $answer)
    {
        $answer->status = !$answer->status;
        $answer->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Question $question)
    {
        return view('MyForumBuilder::admin.pages.answer.form', [
            'edit' => false,
            'action' => route('admin.question.answer.store', $question->encrypt_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Question $question)
    {
        $insert = $request->validate([
            'answer' => ['required'],
            'answer_html' => ['nullable'],
            'created_at' => ['required', 'date'],
        ]);

        $answer = new Answer();
        $answer->question_id = $question->id;

        $client = ClientUser::fake()->inRandomOrder()->first();
        $answer->client_id = $client->id;

        $answer->answer = $insert['answer'];
        $answer->answer_html = $insert['answer_html'];

        $answer->created_at = $answer->updated_at = $insert['created_at'];

        $answer->save();

        return redirect()->route('admin.question.answer.index', $question->encrypt_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question, Answer $answer)
    {
        return view('MyForumBuilder::admin.pages.answer.form', [
            'action' => route('admin.question.answer.update', [
                'question' => $question->encrypt_id,
                'answer' => $answer->encrypt_id
            ]),
            'edit' => true,
            'data' => $answer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $insert = $request->validate([
            'answer' => ['required'],
            'answer_html' => ['nullable'],
            'created_at' => ['required', 'date'],
        ]);

        $answer->answer = $insert['answer'];
        $answer->answer_html = $insert['answer_html'];
        $answer->created_at = $answer->updated_at = $insert['created_at'];
        $answer->save();

        return redirect()->route('admin.question.answer.index', $question->encrypt_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }
}
