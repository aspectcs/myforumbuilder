<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Aspectcs\MyForumBuilder\Facades\MyForumBuilder;
use Exception;
use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MyForumBuilder::admin.common.dataTableTools',
            [
                'breadcrumb' => [
                    'heading' => 'Setting\'s',
                    'chunks' => [
                        'Dashboard',
                        'Setting\'s',
                        'View'
                    ]
                ],
                'dataTableJSON' => route('admin.setting.json'),
                'dtHeading' => 'Setting\'s',
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
                            "title" => "Title",
                            "data" => "title",
                        ],
                        /*[
                            "title" => "Status",
                            "className" => "text-center",
                            "data" => "status",
                            "sortable" => false,
                            "searchable" => false
                        ],*/
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
        $query = Setting::select(
            [
                'id',
                'title',
                'status',
                'priority',
                'created_at',
                'updated_at'
            ]
        )->orderBy('priority', 'ASC');
        return Datatables::of($query)
            ->addIndexColumn()
           /* ->addColumn('status', function (Setting $setting) {
                return view('MyForumBuilder::admin.common.status', [
                    'status' => $setting->status,
                    'updateUrl' => route('admin.setting.status', $setting->encrypt_id),
                ]);
            })*/
            ->addColumn('action', function (Setting $setting) {
                return view('MyForumBuilder::admin.common.action', [
                    'edit' => route('admin.setting.edit', $setting->encrypt_id),
                ]);
            })
            ->addColumn('created_at', function (Setting $setting) {
                return $setting->created_at->format('M j, Y, h:i a');
            })
            ->addColumn('updated_at', function (Setting $setting) {
                return $setting->updated_at->format('M j, Y, h:i a');
            })
            ->rawColumns(['created_at', 'updated_at', 'status', 'action', 'sub-category'])
            ->make(true);
    }

    /**
     * update the status a new resource.
     */
    public function status(Setting $setting)
    {
        $setting->status = !$setting->status;
        $setting->save();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully updated!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        return view('MyForumBuilder::admin.pages.setting.form', [
            'action' => route('admin.setting.update', $setting->encrypt_id),
            'edit' => true,
            'data' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $data = [];
        if ($setting->id == 10) {
            try {
                $response = MyForumBuilder::validateKeys($request->post('APP_KEY'), $request->post('APP_SECRET'));
            } catch (Exception $e) {
                return redirect()->back()->withErrors([
                    'error' => $e->getMessage()
                ]);
            }
        }
        foreach ($setting->fields as $field) {
            switch ($field['type']) {
                case 'file':
                    if ($request->hasFile($field['name'])) {
                        $file = $request->file($field['name']);
                        $filename = $field['name'] . '.' . $file->extension();
                        $file->storeAs('upload', $filename);
                        $data[$field['name']] = $filename;
                    } else {
                        $data[$field['name']] = $request->post($field['name']);
                    }
                    break;
                case 'navbar':
                case 'footer':
                    if ($request->has('navbar')) {
                        foreach ($request->post('navbar') as $item) {
                            $itemChild = [];
                            if (isset($item['child'])) {
                                foreach ($item['child'] as $item_child) {
                                    $itemChild[] = [
                                        'href' => $item_child['href'],
                                        'label' => $item_child['label'],
                                    ];
                                }
                            }
                            $save = [
                                'href' => $item['href'],
                                'label' => $item['label'],
                                'child' => $itemChild,
                            ];
                            $data[] = $save;
                        }
                    }
                    break;
                case 'section-break':
                    //empty
                    break;
                case 'env':
                    put_permanent_env($field['name'], $request->post($field['name']));
                    break;
                default:
                    $data[$field['name']] = $request->post($field['name']);
                    break;
            }
        }
        $setting->values = $data;
        $setting->save();
        return redirect()->route('admin.setting.index');
    }

}
