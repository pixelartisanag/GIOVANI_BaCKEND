<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::create(['name' => $request->name]);

        return response()->json($group, 201);
    }

    public function addUser(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $group->users()->attach($request->user_id);

        return response()->json(['message' => 'User added to group'], 200);
    }

    public function messages(Group $group)
    {
        return response()->json($group->messages);
    }
}
