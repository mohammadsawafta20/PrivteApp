<?php

namespace App\Http\Controllers\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return view('users.admins.index');
    }
}
