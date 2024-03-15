<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
    */

    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        return view('users', [
            'title' => 'Users',
            'users' => User::orderBy('username')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authentication.register', [
            'title' => 'Registrasi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users|min:3',
            'email' => 'required|email:dns|unique:users',
            'level' => 'required',
            'password' => 'required|min:8',
        ]);

        User::create($validated);

        return redirect('/user')->with('success', 'Pengguna baru berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $user = User::find($id);

        if(User::where('level', 'admin')->count() == 1){
            return back()->with('fail', 'Akun admin tersisa satu jika dihapus nanti siapa yang urus ?');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus !');
    }
}
