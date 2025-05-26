<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $customer = Customer::where('user_id', Auth::id())->first();

        return view('customer.profile.index', compact('user', 'customer'));
    }

    public function update(Request $request)
    {
        if (config('app.is_demo') && in_array(Auth::id(), [1])) {
            return back()->with('error', "You are in a demo version. You are not allowed to change the email for default users.");
        }

        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|numeric|digits_between:10,15',
            'location' => 'nullable|max:255',
            'about' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'about' => $request->about,
        ]);

        $customer = Customer::firstOrCreate(
            ['user_id' => Auth::id()],
            []
        );
        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }
}
