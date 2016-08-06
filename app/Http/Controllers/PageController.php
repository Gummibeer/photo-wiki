<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Michelf\MarkdownExtra;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function getShow(Request $request, $page)
    {
        $page = strtolower(trim($page));

        $title = Str::studly($page);
        $file = $page.'.md';
        if(\Storage::disk('pages')->exists($file)) {
            $content = \Storage::disk('pages')->get($file);
            $html = MarkdownExtra::defaultTransform($content);
            return view('app.page')->with([
                'title' => $title,
                'content' => $html,
            ]);
        }
        abort(404);
    }
}
