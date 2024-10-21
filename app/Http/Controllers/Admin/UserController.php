<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::all();

        $keyword = $request->input('keyword');

        if($keyword !== null){
            $users = User::where('name', 'like', "%{$keyword}%")->orWhere('kana', 'like', "%{$keyword}%")->paginate(15);
            $total = $users->total(); 
        }
        else{
            $users = User::paginate(15);
            $total = 0;
            $keyword = null;
        }

        return view('admin.users.index', compact('users', 'total', 'keyword'));
    }

    public function show(User $user)
    {   
        return view('admin.users.show', compact('user'));
    }
}