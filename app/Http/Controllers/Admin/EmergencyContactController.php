<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::orderBy('order')->get();
        return view('admin.emergency_contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.emergency_contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Bantuan Internal,Lembaga Eksternal',
            'contact_info' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'order' => 'required|integer',
        ]);
        $validated['is_active'] = $request->has('is_active');
        EmergencyContact::create($validated);
        return redirect()->route('admin.emergency-contacts.index')->with('success', 'Kontak darurat berhasil ditambahkan.');
    }

    public function edit(EmergencyContact $emergencyContact)
    {
        return view('admin.emergency_contacts.edit', compact('emergencyContact'));
    }

    public function update(Request $request, EmergencyContact $emergencyContact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Bantuan Internal,Lembaga Eksternal',
            'contact_info' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'order' => 'required|integer',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $emergencyContact->update($validated);
        return redirect()->route('admin.emergency-contacts.index')->with('success', 'Kontak darurat berhasil diperbarui.');
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();
        return redirect()->route('admin.emergency-contacts.index')->with('success', 'Kontak darurat berhasil dihapus.');
    }

    public function toggle(EmergencyContact $emergencyContact)
    {
        $emergencyContact->update(['is_active' => !$emergencyContact->is_active]);
        return back()->with('success', 'Status kontak berhasil diubah.');
    }
}

