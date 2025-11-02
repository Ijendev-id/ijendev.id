<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index() {
        $clients = Client::latest()->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function create() {
        return view('admin.clients.create_edit', ['client' => new Client()]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'jenis_klien' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'website' => 'nullable|url',
            'deskripsi_klien' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clients','public');
        }

        Client::create($data);
        return redirect()->route('admin.clients.index')->with('status','Klien berhasil ditambahkan.');
    }

    public function edit(Client $client) {
        return view('admin.clients.create_edit', compact('client'));
    }

    public function update(Request $request, Client $client) {
        $data = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'jenis_klien' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'website' => 'nullable|url',
            'deskripsi_klien' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clients','public');
        }

        $client->update($data);
        return redirect()->route('admin.clients.index')->with('status','Klien berhasil diperbarui.');
    }

    public function destroy(Client $client) {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('status','Klien berhasil dihapus.');
    }
}
