<?php

namespace App\Services;

use App\Enum\Role;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class GroupService
{
    public function addGroup(string $name, ?string $apiKey, ?int $groupId, ?string $pineconeKey, ?string $pineconeUrl)
    {

        if (self::canModify($groupId)) {
            if (!is_null($groupId)) {
                $group = Group::where('id', $groupId)->first();
                $group->name = $name;
                if (!empty($apiKey)) {
                    $group->open_api_key = Crypt::encryptString($apiKey) ?? null;
                }
                if (!empty($pineconeKey)) {
                    $group->pinecone_api_key = Crypt::encryptString($pineconeKey) ?? null;
                }
                if (!empty($pineconeUrl)) {
                    $group->pinecone_api_url = Crypt::encryptString($pineconeUrl) ?? null;
                }

                $group->save();
            } else {
                $group = Group::create([
                    'name' => $name,
                    'open_api_key' => Crypt::encryptString($apiKey) ?? null,
                    'pinecone_api_key' => Crypt::encryptString($pineconeKey) ?? null,
                    'pinecone_api_url' => Crypt::encryptString($pineconeUrl) ?? null,
                ]);
            }

            if ($group) {
                return $this->generateSuccessResponse('Successfully added a group');
            }
        } else {
            return $this->generateErrorResponse('You dont have permission');
        }
        return $this->generateErrorResponse('Failed to add group');
    }

    public function modifyUser(string $name, string $email, string $password, int $groupId, string $usedAPI, string $usedPinecone, string $mode, ?int $userId, string $role)
    {


        $group = $this->getGroupById($groupId);
        if (!$group) {
            return $this->generateErrorResponse('No such group has been found');
        }

        if (self::canModify($groupId)) {

            if ($mode == 'create') {
                return $this->createUserAndAddToGroup($name, $email, $password, $groupId, $usedAPI, $role, $usedPinecone);
            } else {
                return $this->modifyExistingUser($name, $email, $password, $groupId, $usedAPI, $userId, $role, $usedPinecone);
            }

        } else {
            return $this->generateErrorResponse('You dont have permission');
        }

    }

    private function getGroupById(int $groupId)
    {
        return Group::where('id', $groupId)->first();
    }

    private function createUserAndAddToGroup(string $name, string $email, string $password, int $groupId, string $usedAPI, string $role, string $usedPinecone)
    {
        $user = $this->createUser($name, $email, $password);
        $groupUser = $this->createGroupUser($user, $groupId, $usedAPI, $role, $usedPinecone);

        if ($groupUser) {
            return $this->generateSuccessResponse('Successfully added a user to the group');
        }
        return $this->generateErrorResponse('An error occurred while adding a user to a group');
    }

    private function createUser(string $name, string $email, string $password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => Role::USER->value
        ]);
    }

    private function createGroupUser(User $user, int $groupId, string $usedAPI, string $role, string $usedPinecone)
    {
        $roleGroupId = Role::getNumberByRole($role);
        if (GroupUser::where('group_id', $groupId)->count() === 0) {
            $roleGroupId = Role::MODERATOR->value;
            $user->role_id = Role::MODERATOR->value;
            $user->save();
        }

        return GroupUser::create([
            'user_id' => $user->id,
            'group_id' => $groupId,
            'used_api' => $usedAPI,
            'used_long_term' => $usedPinecone,
            'role_id' => $roleGroupId
        ]);
    }

    private function modifyExistingUser(string $name, string $email, string $password, int $groupId, string $usedAPI, ?int $userId, string $role, string $usedPinecone)
    {
        $groupUser = $this->getGroupUser($groupId, $userId);
        if (!$groupUser) {
            return $this->generateErrorResponse('Such a user does not belong to this group');
        }

        $user = $this->getUserById($userId);
        if (!$user) {
            return $this->generateErrorResponse('Such a user does not exist');
        }

        $this->updateUser($user, $name, $email, $password);
        $this->updateGroupUser($groupUser, $usedAPI, $role, $usedPinecone);

        return $this->generateSuccessResponse('Successfully modify user');
    }

    public function deleteUser(int $groupId, string $mode, int $userId): array
    {
        $groupUser = $this->getGroupUser($groupId, $userId);
        if (!$groupUser || $mode != 'edit') {
            return $this->generateErrorResponse('Such a user does not belong to this group');
        }

        $user = $this->getUserById($userId);
        if (!$user) {
            return $this->generateErrorResponse('Such a user does not exist');
        }

        if (self::canModify($groupId) && $groupUser->user_id !== Auth::user()->id) {
            if ($user->delete() && $groupUser->delete()) {
                return $this->generateSuccessResponse('User successfully removed');
            }

        } else {
            return $this->generateErrorResponse('You dont have permission');
        }


        return $this->generateErrorResponse('There was a problem when deleting a user');
    }

    private function getGroupUser(int $groupId, int $userId)
    {
        return GroupUser::where('group_id', $groupId)->where('user_id', $userId)->first();
    }

    private function getUserById(int $userId)
    {
        return User::where('id', $userId)->first();
    }

    private function updateUser(User $user, string $name, string $email, string $password)
    {
        $user->name = $name;
        $user->email = $email;

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }
        $user->save();
    }

    private function updateGroupUser(GroupUser $groupUser, string $usedAPI, string $role, string $usedPinecone)
    {
        if($groupUser->user_id !== Auth::user()->id){
            $groupUser->update([
                'role_id' => Role::getNumberByRole($role),
            ]);
        }

        $groupUser->update([
            'used_api' => $usedAPI,
            'used_long_term' => $usedPinecone,
        ]);
    }

    private function generateSuccessResponse(string $message)
    {
        return [
            'status' => 'success',
            'message' => $message
        ];
    }

    private function generateErrorResponse(string $message)
    {
        return [
            'status' => 'danger',
            'message' => $message
        ];
    }

    public static function canModify($groupId)
    {
        $canModify = GroupUser::where('group_id', $groupId)->where('user_id', Auth::user()->id)->whereIn('role_id', [2, 3])->count();
        if (Auth::user()->role_id == Role::ADMINISTRATOR->value) {
            $canModify = 1;
        }
        return (bool)$canModify;
    }


}
