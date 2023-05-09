<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.category.create'),
                'breadcrumb' => [
                    'heading' => 'Categories',
                    'chunks' => [
                        'Dashboard',
                        'Categories',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.category.json'),
                'dtHeading' => 'Category Master',
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
                            "title" => "Sub Categories",
                            "data" => "sub-category",
                        ],
                        [
                            "title" => "Topics Count",
                            "data" => "questions_count",
                            "sortable" => false,
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
        $query = Category::select(
            [
                'id',
                'name',
                'popular',
                'slug',
                'status',
                'created_at',
                'updated_at'
            ]
        )->withCount('questions');

        if (!request()->post('order')) {
            $query->orderBy('priority', 'DESC');
        }
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('sub-category', function (Category $category) {
                return '<a href="' . route('admin.category.sub-category.index', $category->encrypt_id) . '"><i class="badge bg-info">' . $category->subCategories()->count() . '</i> </a>';
            })
            ->orderColumn('questions_count', function ($query, $order) {
                $query->orderBy('questions_count', $order);
            })
            ->addColumn('status', function (Category $category) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $category->status,
                    'updateUrl' => route('admin.category.status', $category->encrypt_id),
                ]);
            })
            ->addColumn('popular', function (Category $category) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $category->popular,
                    'updateUrl' => route('admin.category.popular', $category->encrypt_id),
                ]);
            })
            ->addColumn('action', function (Category $category) {
                return view('MyForumBuilder::admin.common.action', [
                    'view' => route('category', $category->slug),
                    'edit' => route('admin.category.edit', $category->encrypt_id),
                    'delete' => route('admin.category.destroy', $category->encrypt_id)
                ]);
            })
            ->addColumn('created_at', function (Category $category) {
                return $category->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (Category $category) {
                return $category->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action', 'sub-category'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(Category $category)
    {
        $category->status = !$category->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }


    public function popular(Category $category)
    {
        $category->popular = !$category->popular;
        $category->save();

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
        return view('MyForumBuilder::admin.pages.category.form', [
            'edit' => false,
            'action' => route('admin.category.store')
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
            'description' => ['nullable'],
            'priority' => ['nullable', 'numeric'],

            'meta_title' => ['sometimes'],
            'meta_description' => ['sometimes'],
            'slug' => ['nullable', Rule::unique(Category::class)],
        ]);

        $category = new Category();
        $category->name = $insert['name'];
        $category->priority = $insert['priority'];
        $category->slug = $insert['slug'];
        $category->description = $insert['description'];

        $category->meta_title = @$insert['meta_title'];
        $category->meta_description = @$insert['meta_description'];
        $category->save();

        return redirect()->route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('MyForumBuilder::admin.pages.category.form', [
            'action' => route('admin.category.update', $category->encrypt_id),
            'edit' => true,
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('name');

        $insert = $request->validate([
            'name' => ['required'],
            'description' => ['nullable'],
            'priority' => ['nullable', 'numeric'],

            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'slug' => ['nullable', Rule::unique(Category::class)->ignore($category->id)],
        ]);
        $category->name = $insert['name'];
        $category->priority = $insert['priority'];
        $category->slug = $insert['slug'];
        $category->description = $insert['description'];

        $category->meta_title = @$insert['meta_title'];
        $category->meta_description = @$insert['meta_description'];
        $category->save();

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }
}
