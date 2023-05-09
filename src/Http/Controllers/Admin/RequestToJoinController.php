<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\RequestToJoin;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RequestToJoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                //'addNew' => route('admin.scheduler.create'),
                'breadcrumb' => [
                    'heading' => 'Request To Join',
                    'chunks' => [
                        'Dashboard',
                        'Request To Join',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.request-to-join.json'),
                'dtHeading' => 'Request To Join',
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
                            "title" => "First Name",
                            "data" => "first_name",
                        ],
                        [
                            "title" => "Last name",
                            "data" => "last_name",
                        ],
                        [
                            "title" => "Email",
                            "data" => "email",
                        ],
                        [
                            "title" => "Created at",
                            "data" => "created_at",
                        ],
                        [
                            "title" => "Updated at",
                            "data" => "updated_at",
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
        $query = RequestToJoin::select(
            [
                'id',
                'first_name',
                'last_name',
                'email',
                'created_at',
                'updated_at'
            ]
        )->orderBy('id', 'DESC');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function (RequestToJoin $requestToJoin) {
                return $requestToJoin->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (RequestToJoin $requestToJoin) {
                return $requestToJoin->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at'])
            ->make(true);
    }

}
