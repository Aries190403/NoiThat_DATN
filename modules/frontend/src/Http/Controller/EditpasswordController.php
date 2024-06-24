<?php

namespace Modules\Frontend\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EditpasswordController extends Controller
{
    public function editpassword()
    {
        return view('frontend::layout.editpassword');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The old password is incorrect.');
                }
            }],
            'password' => [
                'required',
                'string',
                'min:6', // Minimum length 8 characters
                'different:old_password', // Must be different from the old password
            ],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'old_password.required' => 'The old password field is required.',
            'password.required' => 'The new password field is required.',
            'password.min' => 'The new password must be at least 6 characters.',
            'password.different' => 'The new password must be different from the old password.',
            'password_confirmation.required' => 'The password confirmation field is required.',
            'password_confirmation.same' => 'The password confirmation does not match the new password.',
        ]);

        // Update password
        try {
            $hashedPassword = Hash::make($request->password);

            DB::table('users')->where('id', Auth::id())->update(['password' => $hashedPassword]);

            return redirect('/profile')->with('ok', 'Password changed successfully!');
        } catch (\Exception $e) {
            return back()->with('no', 'Failed to change password. ' . $e->getMessage());
        }
    }
}
