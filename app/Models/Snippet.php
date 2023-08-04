<?php

namespace App\Models;

use App\Enum\Role;
use App\Services\SnippetInvoker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Snippet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'prompt', 'type', 'webhook', 'user_id', 'mode'
    ];

    public static function getSnippets(string $avatar)
    {
        $currentUserId = Auth::user()->id;
        $snippets = self::where('type', 'system')->where('avatar', $avatar)->get();
        if($avatar == 'dely'){
            $privateSnippets = self::where('type', 'private')->where('user_id', $currentUserId)->get();
            $snippets = $privateSnippets->merge($snippets);
        }

        $groups = GroupUser::where('user_id', $currentUserId)->get();
        foreach ($groups as $currentGroup){
            $groupId = $currentGroup->group_id;
            $groupUserIds = GroupUser::where('group_id', $groupId)->pluck('user_id')->toArray();
            $groupSnippets = self::whereIn('user_id', $groupUserIds)
                ->where('type', \App\Enum\SnippetType::GROUP->value)
                ->get();
            $snippets = $snippets->merge($groupSnippets);
        }

        $snippetInvoker = app(SnippetInvoker::class);
        $filteredData = $snippets->filter(function ($snippet) use ($snippetInvoker) {
            return $snippetInvoker->canDisplaySnippet($snippet->mode);
        })->map(function ($snippet) {
            return [
                'id' => $snippet->id,
                'mode' => $snippet->mode,
                'text' => $snippet->name
            ];
        });

        return $filteredData->toArray();
    }

    public static function processName(string $name): string
    {
        return str_replace([' ', '-', ';', '/', '"', '(', ')'], '', strtolower($name)).'-'.date('His');
    }

    public static function hasPermissionToModify(Snippet $snippet): bool
    {
        if (Auth::user()->role_id == Role::ADMINISTRATOR->value) {
            return true;
        }

        if($snippet->user_id == Auth::user()->id){
            return true;
        }
        return false;
    }
}
