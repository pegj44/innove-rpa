<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function getSettings(Request $request)
    {
        $settings = requestApi('get', 'user/settings', $request->except('_token'));

        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $settings = requestApi('post', 'user/settings', $request->except('_token'));

        if (!empty($settings['validation_error'])) {
            return response()->json($settings['validation_error']);
        }

        if (!empty($settings['errors'])) {
            return response()->json($settings['errors']);
        }

        return response()->json($settings['message']);
    }

    public function update(Request $request)
    {
        $settings = requestApi('put', 'user/settings', $request->except('_token'));

        if (!empty($settings['validation_error'])) {
            return response()->json($settings['validation_error']);
        }

        if (!empty($settings['errors'])) {
            return response()->json($settings['errors']);
        }

        return response()->json($settings['message']);
    }

    public function destroy(string $id)
    {
        $settings = requestApi('delete', 'user/settings/'. $id);

        if (!empty($settings['errors'])) {
            return response()->json($settings['errors']);
        }

        return response()->json($settings['message']);
    }
}
