<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    function sub_category(Request $request)
    {
        return SubCategory::select('name','id')->where('category_id',$request->category_id)->get();
    }
}
