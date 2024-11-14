<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getHtmlTemplate(Request $request)
    {
        $template = $request->get('template');
        $params = (!empty($request->get('data')))? $request->get('data') : [];

        return response()->json(['template' => view($template, $params)->render()]);
    }
}
