<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(UpdateUsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        

        return $user;
    }

    public function store(StoreUsersRequest $request)
    {
        $user = User::create($request->all());
        

        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return '';
    }
}
