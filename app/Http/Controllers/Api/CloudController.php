<?php

namespace App\Http\Controllers\Api;

use App\Class\OpenAiMessage;
use App\Enum\TypeMessage;
use App\Helpers\CloudHelper;
use App\Http\Controllers\Controller;
use App\Models\FileCloud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CloudController extends Controller
{

    private OpenAiMessage $openAiMessage;

    /**
     * @param OpenAiMessage $openAiMessage
     */
    public function __construct(OpenAiMessage $openAiMessage)
    {
        $this->openAiMessage = $openAiMessage;
    }


    public function addImage(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->storeAs('public/cloud', $imageName);


        $fileCloud = new FileCloud();
        $fileCloud->user_id = Auth::user()->id;
        $fileCloud->uuid = CloudHelper::getUuid();
        $fileCloud->file = $imageName;
        $fileCloud->filetype = $request->file('image')->getClientMimeType();
        $fileCloud->showed = 0;
        $fileCloud->save();
        $url = asset('/cloud/'. $fileCloud->uuid);
        $this->openAiMessage->addMessage('Send file...',null, $request->get('avatar'));
        $this->openAiMessage->addResult('Added file: <br/>'. $url . '<br/><br/>' . '<img src="'.$url.'" />', TypeMessage::IMAGE,null,null);



        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'image' => $imageName,
            'url' => $url
        ]);
    }

    public function show($uuid){

        $fileCloud = FileCloud::where('uuid', $uuid)->first();
        $path = 'public/cloud/'.$fileCloud->file;
        if (!$fileCloud || !Storage::exists($path)) {
            abort(404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        $response = response($file, 200)->header('Content-Type', $type);

        return $response;
    }

}
