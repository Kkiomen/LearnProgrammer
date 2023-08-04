<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function getAvatars(){
        return response()->json(Avatar::select(['img', 'name', 'short_name', 'type', 'category', 'sort'])->get());
    }

    public function getAvatar(Request $request, $shortName){
        $canUseMemoryTerm = [
            'canUseMemoryTerm' => ApiHelper::canUseMemoryTerm()
        ];
        $user = $request->user();
        $user->update(['active_avatar' => $shortName]);
        $avatar = Avatar::select(['img', 'name', 'short_name', 'type', 'category'])->where('short_name', $shortName)->first();

        $result = array_merge($canUseMemoryTerm, $avatar->toArray());
        return response()->json($result);
    }
}
