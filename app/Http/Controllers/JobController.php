<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('is_active', true)
                   ->with('user')
                   ->orderBy('created_at', 'desc')
                   ->paginate(12);
        
        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::with('user')->findOrFail($id);
        return view('jobs.show', compact('job'));
    }
}
