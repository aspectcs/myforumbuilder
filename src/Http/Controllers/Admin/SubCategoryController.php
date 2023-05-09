<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.category.sub-category.create', $category->encrypt_id),
                'breadcrumb' => [
                    'heading' => 'Categories',
                    'chunks' => [
                        'Dashboard',
//                        'Category',
                        $category->name,
                        'Sub Categories',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.category.sub-category.json', $category->encrypt_id),
                'dtHeading' => 'Sub Category',
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
    public function json(Category $category)
    {
        $query = $category->subCategories()->select(
            [
                'id',
                'category_id',
                'name',
                'status',
                'slug',
                'created_at',
                'updated_at'
            ]
        )->orderBy('priority', 'DESC');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function (SubCategory $subCategory) use ($category) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $subCategory->status,
                    'updateUrl' => route('admin.category.sub-category.status', [
                        'category' => $category->encrypt_id,
                        'sub_category' => $subCategory->encrypt_id
                    ]),
                ]);
            })
            ->addColumn('action', function (SubCategory $subCategory) use ($category) {
                return view('MyForumBuilder::admin.common.action', [
                    'view' => route('sub-category', [
                        'category' => $category->slug,
                        'subCategory' => $subCategory->slug
                    ]),
                    'edit' => route('admin.category.sub-category.edit', [
                        'category' => $category->encrypt_id,
                        'sub_category' => $subCategory->encrypt_id
                    ]),
                    'delete' => route('admin.category.sub-category.destroy', [
                        'category' => $category->encrypt_id,
                        'sub_category' => $subCategory->encrypt_id
                    ])
                ]);
            })
            ->addColumn('created_at', function (SubCategory $subCategory) {
                return $subCategory->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (SubCategory $subCategory) {
                return $subCategory->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(Category $category, SubCategory $subCategory)
    {
        $subCategory->status = !$subCategory->status;
        $subCategory->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        return view('MyForumBuilder::admin.pages.sub-category.form', [
            'edit' => false,
            'action' => route('admin.category.sub-category.store', $category->encrypt_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('name');
        $insert = $request->validate([
            'name' => ['required'],
            'priority' => ['nullable', 'numeric'],

            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'slug' => ['nullable', Rule::unique(SubCategory::class)],
        ]);

        $subCategory = new SubCategory();
        $subCategory->category_id = $category->id;
        $subCategory->name = $insert['name'];
        $subCategory->priority = $insert['priority'];
        $subCategory->slug = $insert['slug'];

        $subCategory->meta_title = $insert['meta_title'];
        $subCategory->meta_description = $insert['meta_description'];

        $subCategory->save();

        return redirect()->route('admin.category.sub-category.index', $category->encrypt_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category, SubCategory $subCategory)
    {
        return view('MyForumBuilder::admin.pages.sub-category.form', [
            'action' => route('admin.category.sub-category.update', [
                'category' => $category->encrypt_id,
                'sub_category' => $subCategory->encrypt_id
            ]),
            'edit' => true,
            'data' => $subCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, SubCategory $subCategory)
    {

        $request['slug'] = $request->filled('slug') ? $request->input('slug') : $request->input('name');
        $insert = $request->validate([
            'name' => ['required'],
            'priority' => ['nullable', 'numeric'],

            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'slug' => ['nullable', Rule::unique(SubCategory::class)->ignore($subCategory->id)],
        ]);
        $subCategory->name = $insert['name'];
        $subCategory->priority = $insert['priority'];
        $subCategory->slug = $insert['slug'];

        $subCategory->meta_title = $insert['meta_title'];
        $subCategory->meta_description = $insert['meta_description'];

        $subCategory->save();

        return redirect()->route('admin.category.sub-category.index', $category->encrypt_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, SubCategory $subCategory)
    {
        $subCategory->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }
}
