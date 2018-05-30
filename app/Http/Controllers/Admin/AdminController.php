<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return redirect()->route('admin.quiz-template.index');
    }
}
