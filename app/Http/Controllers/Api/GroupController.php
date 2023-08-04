<?php

namespace App\Http\Controllers\Api;

use App\Enum\Role;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupUser;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    private GroupService $groupService;

    /**
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }


    public function addGroup(Request $request)
    {
        $status = $this->groupService->addGroup(
            $request->get('name'),
            $request->get('apiKey') ?? null,
            $request->get('groupId') ?? null,
            $request->get('pineconeKey') ?? null,
            $request->get('pineconeUrl') ?? null
        );

        return response()->json($status);
    }

    public function getGroups()
    {
        if (Auth::user()->role_id == Role::ADMINISTRATOR->value) {
            $groups = Group::select(['name', 'id'])->get();
        }else{
            $groups = Group::join('group_users', 'groups.id', '=', 'group_users.group_id')
                ->where('group_users.user_id', Auth::user()->id)
                ->select(['groups.name', 'groups.id'])
                ->get();
        }



        return $groups->map(function ($group) {
            $canModify = GroupService::canModify($group->id);
            return [
                'id' => $group->id,
                'name' => $group->name,
                'can_modify' => (bool)$canModify,
                'users' => GroupUser::where('group_id', $group->id)->get()->map(function ($groupUser) use($group) {
                    $user = $groupUser->user;
                    return [
                        'name' => $user->name ?? '',
                        'user_id' => $user->id ?? '',
                        'role' => Role::getRoleByNumber($groupUser->role_id)->name,
                    ];
                })
            ];
        });
    }

    public function getUser(Request $request, $group, $id)
    {
        $groupUser = GroupUser::where('group_id', $group)->where('user_id', $id)->first();
        $user = $groupUser->user;
        if($groupUser){
            $response = [
                'status' => 'success',
                'response' => [
                    'name' => $user->name,
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'used_api' => $groupUser->used_api,
                    'used_long_term' => $groupUser->used_long_term,
                    'role' => Role::getRoleByNumber($groupUser->role_id)->name
                ]
            ];
        }else{
            $response = [
                'status' => 'danger',
                'message' => 'No such user found'
            ];
        }


        return response()->json($response);
    }

    public function addUser(Request $request)
    {
        $status = $this->groupService->modifyUser(
            $request->get('name'),
            $request->get('email'),
            $request->get('password') ?? '',
            $request->get('groupId'),
            $request->get('usedAPI'),
            $request->get('usedPinecone'),
            $request->get('mode'),
            $request->get('userId'),
            $request->get('role'),
        );

        return response()->json($status);
    }

    public function deleteUser(Request $request){
        $status = $this->groupService->deleteUser(
            $request->get('groupId'),
            $request->get('mode'),
            $request->get('userId'),
        );

        return response()->json($status);
    }
}
