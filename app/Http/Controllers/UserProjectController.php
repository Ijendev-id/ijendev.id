<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;

class UserProjectController extends Controller
{
    /**
     * Daftar proyek yang terkait dengan client yang email-nya sama dengan user saat ini.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // ambil id client yang terdaftar dengan email user
        $clientIds = Client::where('email', $user->email)->pluck('id')->toArray();

        // ambil proyek yang terkait
        $projects = Project::with('client')
            ->whereIn('client_id', $clientIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.projects.index', compact('projects'));
    }

    /**
     * Menampilkan detail proyek — pastikan user memang punya akses (client.email === user.email)
     */
    public function show(Project $project, Request $request)
    {
        $user = $request->user();
        $client = $project->client;

        if (!$client || $client->email !== $user->email) {
            abort(403, 'Anda tidak punya akses ke proyek ini.');
        }

        return view('user.projects.show', compact('project'));
    }
}
