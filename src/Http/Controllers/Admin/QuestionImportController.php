<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\Scheduler;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuestionImportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('MyForumBuilder::admin.pages.question.import.form', [
            'edit' => false,
            'action' => route('admin.questions.import.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:txt,csv']
        ]);

        $file = $request->file('csv_file');
        $path = $file->store('scheduler/question');

        $scheduler = new Scheduler();
        $scheduler->file_path = $path;
        $scheduler->file_name = $file->getClientOriginalName();
        $scheduler->save();

        return redirect()->route('admin.scheduler.index');
    }

    public function sample()
    {
        $fileName = 'questions-sample';
        return response()
            ->streamDownload(function () {
                $handle = fopen('php://output', 'w');

                $headers[] = 'Category (`'.Category::active()->get()->pluck('name')->implode(', `').'`)';
                $headers[] = 'Sub Category (`'.SubCategory::active()->get()->pluck('name')->implode(', `').'`)';
                $headers[] = 'Question';

                fputcsv($handle, $headers);
                fclose($handle);
            }, $fileName . '.csv', [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Disposition' => "attachment; filename={$fileName}.csv",
                'Content-Type' => 'text/csv',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }
}
