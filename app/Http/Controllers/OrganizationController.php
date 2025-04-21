<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Menampilkan daftar Organization.
     */
    public function index()
    {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Menyimpan Organization baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name',
        ]);

        Organization::create([
            'name' => $request->name,
        ]);

        return redirect()->route('organizations.index')->with('success', 'Organization berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit Organization.
     */
    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Memperbarui Organization yang ada.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $organization->id,
        ]);

        $organization->update([
            'name' => $request->name,
        ]);

        return redirect()->route('organizations.index')->with('success', 'Organization berhasil diperbarui.');
    }

    /**
     * Menghapus Organization.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organization berhasil dihapus.');
    }
}
