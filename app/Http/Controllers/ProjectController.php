<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::with('client')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create() {
        $clients = Client::orderBy('nama_klien')->get();
        return view('admin.projects.create_edit', ['project'=>new Project(),'clients'=>$clients]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nama_proyek' => 'required|string|max:255',
            'kategori_proyek' => 'nullable|string|max:100',
            'deskripsi_proyek' => 'nullable|string',
            'fitur_utama' => 'nullable|string',
            'teknologi_digunakan' => 'nullable|string|max:255',
            'status_proyek' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'nilai_proyek' => 'nullable|numeric',
            'url_demo' => 'nullable|url',
            'repo_url' => 'nullable|url',
            'catatan_tambahan' => 'nullable|string',
            'gambar_proyek' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('gambar_proyek')) {
            $data['gambar_proyek'] = $request->file('gambar_proyek')->store('projects','public');
        }

        Project::create($data);
        return redirect()->route('admin.projects.index')->with('status','Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project) {
        $clients = Client::orderBy('nama_klien')->get();
        return view('admin.projects.create_edit', compact('project','clients'));
    }

    public function update(Request $request, Project $project) {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nama_proyek' => 'required|string|max:255',
            'kategori_proyek' => 'nullable|string|max:100',
            'deskripsi_proyek' => 'nullable|string',
            'fitur_utama' => 'nullable|string',
            'teknologi_digunakan' => 'nullable|string|max:255',
            'status_proyek' => 'nullable|string|max:50',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'nilai_proyek' => 'nullable|numeric',
            'url_demo' => 'nullable|url',
            'repo_url' => 'nullable|url',
            'catatan_tambahan' => 'nullable|string',
            'gambar_proyek' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('gambar_proyek')) {
            $data['gambar_proyek'] = $request->file('gambar_proyek')->store('projects','public');
        }

        $project->update($data);
        return redirect()->route('admin.projects.index')->with('status','Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project) {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('status','Proyek berhasil dihapus.');
    }
}
