<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%')
                  ->orWhere('role','like','%'.$request->search.'%');

            });

        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name'=>'required|max:100',

            'email'=>'required|email|unique:users,email',

            'role'=>'required|in:admin,petugas',

            'password'=>'required|confirmed|min:8',

        ]);

        User::create([

            'name'=>$validated['name'],

            'email'=>$validated['email'],

            'role'=>$validated['role'],

            'password'=>Hash::make($validated['password'])

        ]);

        ActivityLogger::log(
            'Menambahkan user',
            'Manajemen User',
            'CREATE'
        );

        return redirect()
            ->route('user.index')
            ->with('success','User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,petugas',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => auth()->id() == $user->id
                        ? $user->role
                        : $request->role,
        ]);

        ActivityLogger::log(
            'Mengubah user',
            'Manajemen User',
            'UPDATE'
        );

        return redirect()
            ->route('user.index')
            ->with('success','User berhasil diupdate.');
    }


    public function editPassword(User $user)
    {
        return view('user.password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLogger::log(
            'Mengubah password user',
            'Manajemen User',
            'UPDATE'
        );

        return redirect()
            ->route('user.index')
            ->with('success', 'Password berhasil diperbarui.');
    }
    
    public function destroy(User $user)
    {
        if($user->id==auth()->id()){

            return back()
                ->with('error','Tidak dapat menghapus akun sendiri.');

        }

        $user->delete();

        ActivityLogger::log(
            'Menghapus user',
            'Manajemen User',
            'DELETE'
        );

        return redirect()
            ->route('user.index')
            ->with('success','User berhasil dihapus.');
    }
}