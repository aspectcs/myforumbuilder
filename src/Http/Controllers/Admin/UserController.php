<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.user.create'),
                'breadcrumb' => [
                    'heading' => 'User\'s',
                    'chunks' => [
                        'Dashboard',
                        'User\'s',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.user.json'),
                'dtHeading' => 'User Master',
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
                            "title" => "Email",
                            "data" => "email",
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
    public function json()
    {
        $query = User::select(
            [
                'id',
                'name',
                'email',
                'status',
                'created_at',
                'updated_at'
            ]
        );
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function (User $user) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $user->status,
                    'updateUrl' => route('admin.user.status', $user->encrypt_id),
                ]);
            })
            ->addColumn('action', function (User $user) {
                return view('MyForumBuilder::admin.common.action', [
                    'edit' => route('admin.user.edit', $user->encrypt_id),
                    'delete' => route('admin.user.destroy', $user->encrypt_id)
                ]);
            })
            ->addColumn('created_at', function (User $user) {
                return $user->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (User $user) {
                return $user->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(User $user)
    {
        $user->status = !$user->status;
        $user->save();

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
        return view('MyForumBuilder::admin.pages.user.form', [
            'edit' => false,
            'action' => route('admin.user.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $insert = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['required']
        ]);

        $user = new User();
        $user->name = $insert['name'];
        $user->email = $insert['email'];
        $user->password = Hash::make($insert['password']);
        $user->is_admin = true;
        $user->save();

        return redirect()->route('admin.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('MyForumBuilder::admin.pages.user.form', [
            'action' => route('admin.user.update',$user->encrypt_id),
            'edit' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $insert = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['sometimes']
        ]);
        $user->name = $insert['name'];
        $user->email = $insert['email'];

        if ($request->filled('password'))
            $user->password = Hash::make($insert['password']);

        $user->save();

        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }
}
