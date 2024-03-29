<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
    {
        // Update a new file
        $path = $request->file('avatar')->store('avatars', 'public');

        // Delete old file
        if($oldAvatar = $request->user()->avatar)
        {
            Storage::disk('public')->delete($oldAvatar);
        }

        // Update the user avatar path
        auth()->user()->update(['avatar' => $path]);

        // Store avatar
        return redirect(route('profile.edit'))->with('message', 'Avatar is updated');
    }
}
