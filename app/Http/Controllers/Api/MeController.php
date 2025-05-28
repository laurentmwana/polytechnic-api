<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserMeResource;

class MeController extends Controller
{
    public function __invoke(Request $request): UserMeResource
    {
        return new UserMeResource($request->user());
    }
}
