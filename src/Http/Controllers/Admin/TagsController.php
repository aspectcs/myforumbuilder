<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TagsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.tag.create'),
                'breadcrumb' => [
                    'heading' => 'Tags',
                    'chunks' => [
                        'Dashboard',
                        'Tags',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.tag.json'),
                'dtHeading' => 'Tag Master',
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
                            "title" => "Name",
                            "data" => "name",
                        ], [
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
                            "title" => "Topics Count",
                            "data" => "questions_count",
                            "searchable" => false
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

                    ]
                ]
            ]);
    }

    /**
     * Display a JSON listing of the resource.
     */
    public function json()
    {
        $query = Tag::select(
            [
                'id',
                'name',
                'popular',
                'status',
                'slug',
                'created_at',
                'updated_at',
            ]
        )->withCount('questions');
        if (!request()->post('order')) {
            $query->orderBy('id', 'DESC');
        }
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('popular', function (Tag $tag) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $tag->popular,
                    'updateUrl' => route('admin.tag.popular', $tag->encrypt_id),
                ]);
            })
            ->addColumn('status', function (Tag $tag) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $tag->status,
                    'updateUrl' => route('admin.tag.status', $tag->encrypt_id),
                ]);
            })
            ->addColumn('action', function (Tag $tag) {
                return view('MyForumBuilder::admin.common.action', [
                    'view' => route('tag', $tag->slug),
                    'edit' => route('admin.tag.edit', $tag->encrypt_id),
                    'delete' => route('admin.tag.destroy', $tag->encrypt_id)
                ]);
            })
            ->addColumn('created_at', function (Tag $tag) {
                return $tag->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (Tag $tag) {
                return $tag->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(Tag $tag)
    {
        $tag->status = !$tag->status;
        $tag->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }

    public function popular(Tag $tag)
    {
        $tag->popular = !$tag->popular;
        $tag->save();

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
        return view('MyForumBuilder::admin.pages.tag.form', [
            'edit' => false,
            'action' => route('admin.tag.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('name');
        $insert = $request->validate([
            'name' => ['required'],
            'slug' => ['sometimes', Rule::unique(Tag::class)],

            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
        ]);

        $tag = new Tag();
        $tag->name = $insert['name'];
        $tag->slug = $insert['slug'];

        $tag->meta_title = $insert['meta_title'];
        $tag->meta_description = $insert['meta_description'];
        $tag->save();

        return redirect()->route('admin.tag.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('MyForumBuilder::admin.pages.tag.form', [
            'action' => route('admin.tag.update', $tag->encrypt_id),
            'edit' => true,
            'data' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('name');
        $insert = $request->validate([
            'name' => ['required'],
            'slug' => ['nullable', Rule::unique(Tag::class)->ignore($tag->id)],

            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
        ]);
        $tag->name = $insert['name'];
        $tag->slug = $insert['slug'];

        $tag->meta_title = $insert['meta_title'];
        $tag->meta_description = $insert['meta_description'];
        $tag->save();

        return redirect()->route('admin.tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }
}
