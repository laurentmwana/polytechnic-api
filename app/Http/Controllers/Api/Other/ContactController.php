<?php

namespace App\Http\Controllers\Api\Other;

use App\Events\ContactUsEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function __invoke(ContactRequest $request)
    {
        event(new ContactUsEvent($request->validated()));

        return response()->json([
            'state' => true,
        ]);
    }
}
