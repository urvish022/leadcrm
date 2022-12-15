<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use App\Http\Requests\UpdateUserSettingRequest;
use Illuminate\Http\Request;
use Flash;

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

        Flash::success('User Settings updated successfully.');
        return redirect(route('settings.index'));
    }
}