<?php

namespace App\Http\RestApi;

use Illuminate\Contracts\View\View;

class ExampleController
{
    public function __invoke(): View
    {
        return view('example', [
            'application' => 'Rest API',
            'instance' => app()::class,
        ]);
    }
}
