<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocs = Document::count();

        $stats = [
            'total' => $totalDocs,
            'active' => Document::where('status', 'active')->count(),
            'signed' => Document::whereIn('status', ['signed', 'approved'])->count(),
            'rejected' => Document::where('status', 'rejected')->count(),

            'users' => User::count(),
        ];

        $documents = Document::where('created_by', auth()->id())
            ->latest()
            ->take(5)
            ->get();
        $activities = DocumentLog::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
        return view('dashboard', compact('stats', 'documents', 'totalDocs', 'activities'));
    }
}
