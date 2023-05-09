<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Aspectcs\MyForumBuilder\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.question.create'),
                'import' => route('admin.questions.import.create'),
                'breadcrumb' => [
                    'heading' => 'Questions',
                    'chunks' => [
                        'Dashboard',
                        'Questions',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.question.json'),
                'dtHeading' => 'Questions Master',
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
                            "title" => "Category",
                            "data" => "category.name",
                        ],
                        [
                            "title" => "Sub Category",
                            "data" => "sub_category.name",
                        ],
                        [
                            "title" => "Questions",
                            "data" => "question",
                        ],
                        [
                            "title" => "Token Used",
                            "data" => "total_tokens",
                        ],
                        [
                            "title" => "Popular",
                            "className" => "text-center",
                            "data" => "popular",
                            "sortable" => false,
                            "searchable" => false
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
                            "title" => "Answers",
                            "data" => "answers",
                            "className" => "text-center",
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
    public function json()
    {
        $query = Question::select(
            [
                'id',
                'category_id',
                'sub_category_id',
                'question',
                'total_tokens',
                'status',
                'popular',
                'slug',
                'created_at',
                'updated_at'
            ]
        )->with('category','sub_category')->orderBy('id', 'DESC');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('question', function (Question $question) {
                return Str::words($question->question, 10);
            })
            ->filterColumn('question', function ($query, $keyword) {
                $query->where('question', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('answers', function (Question $question) {
                return '<a href="' . route('admin.question.answer.index', $question->encrypt_id) . '"><i class="badge bg-info">' . $question->answers()->count() . '</i> </a>';
            })
            ->addColumn('status', function (Question $question) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $question->status,
                    'updateUrl' => route('admin.question.status', $question->encrypt_id),
                ]);
            })
            ->addColumn('popular', function (Question $question) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $question->popular,
                    'updateUrl' => route('admin.question.popular', $question->encrypt_id),
                ]);
            })
            ->addColumn('action', function (Question $question) {
                return view('MyForumBuilder::admin.common.action', [
                    'view' => route('question', $question->slug),
                    'edit' => route('admin.question.edit', $question->encrypt_id),
                    'delete' => route('admin.question.destroy', $question->encrypt_id)
                ]);
            })
            ->addColumn('created_at', function (Question $question) {
                return $question->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (Question $question) {
                return $question->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'popular', 'action', 'question', 'answers'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(Question $question)
    {
        $question->status = !$question->status;
        $question->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }

    public function popular(Question $question)
    {
        $question->popular = !$question->popular;
        $question->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('MyForumBuilder::admin.pages.question.form', [
            'edit' => false,
            'categories' => Category::active()->get(),
//            'subcategories' => SubCategory::active()->get(),
            'action' => route('admin.question.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('question');
        $insert = $request->validate([
            'category_id' => ['required', 'numeric'],
            'sub_category_id' => ['nullable', 'numeric'],
            'question' => ['required'],
            'description' => ['nullable'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'created_at' => ['required', 'date'],
            'slug' => ['nullable', Rule::unique(Question::class)],
        ]);

        $question = new Question();
        $question->question = $insert['question'];
        $question->category_id = $insert['category_id'];
        if ($request->filled('sub_category_id'))
            $question->sub_category_id = $insert['sub_category_id'];
        $question->slug = $insert['slug'];
        $question->description = $insert['description'];

        $client = ClientUser::fake()->inRandomOrder()->first();
        $question->client_id = $client->id;

        $question->meta_title = $insert['meta_title'];
        $question->meta_description = $insert['meta_description'];
        $question->created_at = $question->updated_at = $insert['created_at'];

        $question->save();

        return redirect()->route('admin.question.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return view('MyForumBuilder::admin.pages.question.form', [
            'action' => route('admin.question.update', $question->encrypt_id),
            'edit' => true,
            'categories' => Category::active()->get(),
//            'subcategories' => SubCategory::active()->get(),
            'data' => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('question');

        $insert = $request->validate([
            'category_id' => ['required', 'numeric'],
            'sub_category_id' => ['nullable', 'numeric'],
            'question' => ['required'],
            'description' => ['nullable'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'created_at' => ['required', 'date'],
            'slug' => ['nullable', Rule::unique(Question::class)->ignore($question->id)],
        ]);
        $question->question = $insert['question'];
        $question->category_id = $insert['category_id'];
        if ($request->filled('sub_category_id'))
            $question->sub_category_id = $insert['sub_category_id'];
        $question->slug = $insert['slug'];
        $question->description = $insert['description'];

        $question->meta_title = $insert['meta_title'];
        $question->meta_description = $insert['meta_description'];
        $question->created_at = $question->updated_at = $insert['created_at'];

        $question->save();

        return redirect()->route('admin.question.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }

}
