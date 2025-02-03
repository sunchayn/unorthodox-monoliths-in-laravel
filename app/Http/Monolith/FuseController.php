<?php

namespace App\Http\Monolith;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class FuseController
{
    public function normal(): View
    {
        app()->detectEnvironment(fn () => 'production');

        $results = DB::table('migrations')->get();

        return view('fuse', [
            'results' => $results,
        ]);
    }

    public function errors(): View
    {
        app()->detectEnvironment(fn () => 'production');

        $results = DB::table('not-found')->get();

        return view('fuse', [
            'results' => $results,
        ]);
    }
}
