<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema; // tambahkan di bagian atas file dengan use lainnya

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

    /**
     * AJAX: search calon klien dari tabel users berdasarkan nama atau email.
     * Route: GET admin/clients/search-candidates
     */
    /**
 * DEBUG: search calon klien — temporary version that returns exception details in JSON.
 * Replace with original after debugging.
 */
public function searchCandidates(Request $request)
{
    try {
        $q = trim($request->query('q', ''));

        if ($q === '') {
            return response()->json(['data' => []]);
        }

        $qLike = '%' . strtolower($q) . '%';

        // kolom yang akan dicoba — urutan prioritas
        $possibleCols = ['name','full_name','username','nama','email'];

        // kumpulkan kolom yang benar-benar ada di tabel `users`
        $available = [];
        foreach ($possibleCols as $col) {
            if (Schema::hasColumn('users', $col)) {
                $available[] = $col;
            }
        }

        // Jika tidak ada kolom nama sama sekali, fallback ke email jika ada, atau ambil semua users (sangat jarang)
        if (empty($available)) {
            if (!Schema::hasColumn('users', 'email')) {
                // tidak ada kolom yang bisa dicari -> kembalikan kosong
                \Log::warning('searchCandidates: no searchable columns found on users table.');
                return response()->json(['data' => []]);
            }

            $results = User::whereRaw('LOWER(email) LIKE ?', [$qLike])
                ->limit(20)
                ->get(['id', 'email']);
            // standartize: set name = email
            $results = $results->map(function($u) {
                return (object)[
                    'id' => $u->id,
                    'name' => $u->email,
                    'email' => $u->email,
                ];
            });
        } else {
            // build query using available columns
            $query = User::query();

            // gunakan LOWER(...) untuk case-insensitive
            $first = array_shift($available);
            $query->whereRaw("LOWER({$first}) LIKE ?", [$qLike]);

            foreach ($available as $col) {
                $query->orWhereRaw("LOWER({$col}) LIKE ?", [$qLike]);
            }

            // pilih kolom yang ingin kita ambil: id, email, dan sebuah kolom name (jika 'name' tidak ada, alias kolom pertama sebagai name)
            $selects = ['id'];
            if (Schema::hasColumn('users', 'email')) {
                $selects[] = 'email';
            } else {
                // pastikan ada email di hasil agar mapping aman — jika tidak ada, set email kosong nanti
            }

            if (Schema::hasColumn('users', 'name')) {
                $selects[] = 'name';
            } else {
                // alias kolom pertama sebagai name supaya view menerima field name
                $selects[] = "{$first} as name";
            }

            $results = $query->limit(20)->get($selects);
        }

        // Pastikan $results adalah koleksi objek dengan ->email dan ->name
        // Cari email client yang sudah ada
        $emails = $results->pluck('email')->filter()->unique()->values()->toArray();
        $clientEmails = [];
        if (!empty($emails)) {
            $clientEmails = Client::whereIn('email', $emails)->pluck('email')->toArray();
        }

        $data = collect($results)->map(function($u) use ($clientEmails) {
            // beberapa record mungkin tidak punya email; atur fallback
            $email = $u->email ?? null;
            $name  = $u->name  ?? ($email ?? "User {$u->id}");
            return [
                'id' => $u->id,
                'name' => $name,
                'email' => $email,
                'exists_as_client' => $email ? in_array($email, $clientEmails) : false,
            ];
        })->values();

        return response()->json(['data' => $data]);
    } catch (\Throwable $e) {
        \Log::error("searchCandidates error: " . $e->getMessage(), ['exception' => get_class($e), 'trace' => $e->getTraceAsString()]);

        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
            'exception' => get_class($e),
        ], 500);
    }
}


    /**
     * Migrasi data dari users ke tabel clients.
     * Route: POST admin/clients/migrate-from-user
     */
    public function migrateFromUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required','integer','exists:users,id'],
        ]);

        $user = User::findOrFail($data['user_id']);

        if ($user->email && Client::where('email', $user->email)->exists()) {
            $existing = Client::where('email', $user->email)->first();
            return redirect()->route('admin.clients.edit', $existing)
                ->with('status', 'Calon klien sudah terdaftar. Anda dialihkan ke halaman edit klien.');
        }

        $client = Client::create([
            'nama_klien' => $user->name ?? $user->email,
            'jenis_klien' => 'Personal',
            'email' => $user->email,
            'telepon' => $user->phone ?? null,
            'alamat' => $user->address ?? null,
            'website' => null,
            'logo' => null,
            'deskripsi_klien' => 'Migrated from users.id:' . $user->id,
        ]);

        return redirect()->route('admin.clients.edit', $client)
            ->with('status', 'Calon klien berhasil dimigrasi ke Clients. Silakan lengkapi data.');
    }
}
