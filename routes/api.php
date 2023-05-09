<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/popular', function (Request $request) {
    $question = \Aspectcs\MyForumBuilder\Models\Question::select('question','slug')->popular()->active()->orderBy('created_at', 'DESC')->take(5)->get();
    foreach ($question as $index=>$item) {
        $question[$index]['url'] = route('question',$item->slug);
    }
    return $question;
});
Route::get('/latest', function (Request $request) {
    $question =  \Aspectcs\MyForumBuilder\Models\Question::select('question','slug')->active()->orderBy('created_at', 'DESC')->take(5)->get();
    foreach ($question as $index=>$item) {
        $question[$index]['url'] = route('question',$item->slug);
    }
    return $question;
});
