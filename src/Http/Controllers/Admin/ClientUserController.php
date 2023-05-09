<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ClientUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'addNew' => route('admin.client-user.create'),
                'breadcrumb' => [
                    'heading' => 'User\'s',
                    'chunks' => [
                        'Dashboard',
                        'User\'s',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.client-user.json'),
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
                            "title" => "Username",
                            "data" => "username",
                        ],
                        [
                            "title" => "Email",
                            "data" => "email",
                        ],
                        [
                            "title" => "Type",
                            "data" => "type",
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
        $query = ClientUser::select(
            [
                'id',
                'username',
                'email',
                'type',
                'status',
                'created_at',
                'updated_at'
            ]
        )->orderBy('id', 'DESC');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function (ClientUser $user) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $user->status,
                    'updateUrl' => route('admin.client-user.status', $user->encrypt_id),
                ]);
            })
            ->addColumn('action', function (ClientUser $user) {
                return view('MyForumBuilder::admin.common.action', [
                    'view' => route('user', $user->username),
                    'edit' => route('admin.client-user.edit', $user->encrypt_id),
                    'delete' => route('admin.client-user.destroy', $user->encrypt_id)
                ]);
            })
            ->addColumn('created_at', function (ClientUser $user) {
                return $user->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (ClientUser $user) {
                return $user->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(ClientUser $user)
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
        return view('MyForumBuilder::admin.pages.client-user.form', [
            'edit' => false,
            'action' => route('admin.client-user.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $insert = $request->validate([
            'name' => ['required'],
            'username' => ['required', Rule::unique(ClientUser::class)],
            'email' => ['required', 'email', Rule::unique(ClientUser::class)],
            'password' => ['required']
        ]);

        $user = new ClientUser();
        $user->name = $insert['name'];
        $user->username = $insert['username'];
        $user->email = $insert['email'];
        $user->password = Hash::make($insert['password']);
        $user->save();

        return redirect()->route('admin.client-user.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientUser $user)
    {
        return view('MyForumBuilder::admin.pages.client-user.form', [
            'action' => route('admin.client-user.update', $user->encrypt_id),
            'edit' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientUser $user)
    {
        $insert = $request->validate([
            'name' => ['required'],
            'username' => ['required', Rule::unique(ClientUser::class)],
            'email' => ['required', 'email', Rule::unique(ClientUser::class)->ignore($user->id)],
            'password' => ['sometimes']
        ]);
        $user->name = $insert['name'];
        $user->username = $insert['username'];
        $user->email = $insert['email'];

        if ($request->filled('password'))
            $user->password = Hash::make($insert['password']);

        $user->save();

        return redirect()->route('admin.client-user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientUser $user)
    {
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }
}
