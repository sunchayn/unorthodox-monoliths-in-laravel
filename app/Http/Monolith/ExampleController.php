<?php

namespace App\Http\Monolith;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ExampleController
{
    public function __invoke(Request $request): View
    {
        return view('example', [
            'application' => 'Monolith',
            'instance' => app()::class,
        ]);
    }
}
