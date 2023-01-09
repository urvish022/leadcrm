<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use App\Http\Requests\UpdateUserSettingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Flash;
use Session;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = UserSettings::where('user_id',auth()->id())->first();
        return view('settings.index')->with(compact('setting'));
    }

    public function update($id, UpdateUserSettingRequest $request)
    {
        $input = $request->all();

        $setting = UserSettings::find($id);
        $setting->fill($input);
        $setting->save();

        $allUserSettigns = UserSettings::get()->toArray();

        if (Cache::has('users_settings')) {
            Cache::forget('users_settings');
        }

        Cache::rememberForever('users_settings', function () use($allUserSettigns) {
            return $allUserSettigns;
        });

        $userSettings = UserSettings::where('user_id',auth()->id())->first();
        Session::forget('user-settings');
        Session::put('user-settings', $userSettings);

        Flash::success('User Settings updated successfully.');
        return redirect(route('settings.index'));
    }
}
