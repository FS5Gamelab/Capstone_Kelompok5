<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.user-manage.index', [
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "There were some problems with your input.",
                'errors' => $validator->errors()
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                "phone" => $request->phone,
                "address" => $request->address,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user
            ]);
        }
    }

    public function deleted()
    {
        return view('admin.user-manage.deleted-user', [
            'users' => User::onlyTrashed()->get()
        ]);
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        return response()->json([
            'success' => true,
            'message' => 'User restored successfully'
        ]);
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        $user->products()->update([
            "user_id" => null
        ]);

        $user->orders()->update([
            "user_id" => null
        ]);

        $user->carts()->update([
            "user_id" => null
        ]);
        $user->categories()->update([
            "user_id" => null
        ]);

        $user->reviews()->update([
            "user_id" => null
        ]);
        $user->forceDelete();
        return response()->json([
            'success' => true,
            'message' => 'User permanently deleted successfully'
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
