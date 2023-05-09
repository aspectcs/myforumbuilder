<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\Scheduler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\DataTables;

class SchedulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'customButtons' => [
                    [
                        'label' => 'Import Questions',
                        'url' => route('admin.scheduler.run.artisan', 'import-questions')
                    ],
                    [
                        'label' => 'Calculate Popular Tags',
                        'url' => route('admin.scheduler.run.artisan', 'calculate-popular-tags')
                    ],
                    [
                        'label' => 'Generate Likes',
                        'url' => route('admin.scheduler.run.artisan', 'generate-likes')
                    ],
                    [
                        'label' => 'Generate Weekly Likes',
                        'url' => route('admin.scheduler.run.artisan', 'generate-weekly-likes')
                    ],
                    [
                        'label' => 'Generate Visitor',
                        'url' => route('admin.scheduler.run.artisan', 'generate-visitor')
                    ],
                ],
                //'addNew' => route('admin.scheduler.create'),
                'breadcrumb' => [
                    'heading' => 'Questions',
                    'chunks' => [
                        'Dashboard',
                        'Questions',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.scheduler.json'),
                'dtHeading' => 'Import Questions Master',
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
                            "title" => "File Name",
                            "data" => "file_name",
                        ],
                        [
                            "title" => "Total Count",
                            "data" => "total_count",
                        ],
                        [
                            "title" => "Success Count",
                            "data" => "success_count",
                        ],
                        [
                            "title" => "Error Count",
                            "data" => "error_count",
                        ],
                        [
                            "title" => "Errors",
                            "data" => "errors",
                        ], [
                            "title" => "Status",
                            "data" => "status",
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
        $query = Scheduler::select(
            [
                'id',
                'file_name',
                'file_path',
                'total_count',
                'error_count',
                'success_count',
                'errors',
                'status',
                'created_at',
                'updated_at'
            ]
        )->orderBy('id', 'DESC');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('errors', function (Scheduler $scheduler) {
                return collect($scheduler->errors)->implode('<br>');
            })->addColumn('created_at', function (Scheduler $scheduler) {
                return $scheduler->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (Scheduler $scheduler) {
                return $scheduler->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'errors'])
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scheduler $scheduler)
    {
        $scheduler->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted!'
        ]);
    }

    public function run_artisan($type)
    {
        switch ($type) {
            case 'import-questions':
                Artisan::call('import:questions');
                break;
            case 'calculate-popular-tags':
                Artisan::call('calculate:popular-tags');
                break;
            case 'generate-likes':
                Artisan::call('generate:likes');
                break;
            case 'generate-weekly-likes':
                Artisan::call('generate:weekly-likes');
                break;
            case 'generate-visitor':
                Artisan::call('generate:visitor');
                break;
        }

        return redirect()->route('admin.scheduler.index');
    }
}
