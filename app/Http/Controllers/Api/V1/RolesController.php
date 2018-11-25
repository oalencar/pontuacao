<?php

namespace App\Http\Controllers\Api\V1;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;

class RolesController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function show($id)
    {
        return Role::findOrFail($id);
    }

    public function update(UpdateRolesRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        

        return $role;
    }

    public function store(StoreRolesRequest $request)
    {
        $role = Role::create($request->all());
        

        return $role;
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return '';
    }
}
