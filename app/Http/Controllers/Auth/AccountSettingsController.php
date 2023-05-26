<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Settings\ChangePasswordRequest;
use App\Http\Requests\Auth\Settings\GeneralSettingsRequest;
use App\Models\Client;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AccountSettingsController extends Controller
{
    public function showGeneralInfo()
    {
        return response()->view('crm.pages.account-settings.general-info');
    }

    public function updateGeneralInfo(GeneralSettingsRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone');
        if ($request->hasFile('image')) {
            if ($user->image != null) {
                Storage::disk('public')->delete('' . $user->image);
            }
            $file = $request->file('image');
            $imageName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
            $image = $file->storePubliclyAs('crm/users', $imageName, ['disk' => 'public']);
            $user->image = $image;
        }
        $isSaved = $user->save();
        return response()->json([
            'message' => $isSaved ? 'Settings Updated Successfully!' : 'Failed to save settings, Please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showChangePassword()
    {
        return response()->view('crm.pages.account-settings.change-password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->input('new_password'));
        $isSaved = $user->save();
        return response()->json([
            'message' => $isSaved ? 'Password Changed Successfully!' : 'Failed to change password, Please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showProfile()
    {
        return response()->view('crm.pages.account-settings.profile');
    }

    public function completeRegistration(Request $request)
    {
        $validator = Validator($request->all(), [
            'id_card' => 'required|image',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($request->user()->role == 'advisor') {
            $validatorAdvisor = Validator($request->all(), [
                'type' => 'required|string',
            ]);
            if ($validatorAdvisor->fails()) {
                return response()->json([
                    'message' => $validatorAdvisor->getMessageBag()->first(),
                ], Response::HTTP_BAD_REQUEST);
            }
            if ($request->input('type') == '-1') {
                return response()->json([
                    'message' => 'Please select your classification',
                ], Response::HTTP_BAD_REQUEST);
            }
        }



        $user = $request->user();
        if ($request->hasFile('id_card')) {
            if ($user->image != null) {
                Storage::disk('public')->delete('' . $user->image);
            }
            $file = $request->file('id_card');
            $imageName = time() . '_' . rand(1, 1000000) . '.' . $file->getClientOriginalExtension();
            $image = $file->storePubliclyAs('crm/users/card', $imageName, ['disk' => 'public']);
            $user->id_card = $image;
        }
        if ($request->user()->role == 'advisor') {
            $user->type = $request->input('type');
        }
        $isSaved = $user->save();
        return response()->json([
            'message' => $isSaved ? 'Registration Completed!' : 'Failed to register, please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function updateAccomplishments(Request $request)
    {
        $validator = Validator($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user();
        $user->accomplishments = $request->input('content');
        $isSaved = $user->save();
        return response()->json([
            'message' => $isSaved ? 'Accomplishments Updated!' : 'Failed to update accomplishments, please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function accomplishments(Request $request)
    {
        return response()->view('crm.pages.account-settings.accomplishments');
    }
}
