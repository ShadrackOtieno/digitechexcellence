<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.account', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->getKey())],
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:10|confirmed',
        ]);

        if (! empty($data['new_password'])) {
            if (! Hash::check($data['current_password'] ?? '', $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = $data['new_password'];
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return back()->with('success', 'Account updated.');
    }
}
