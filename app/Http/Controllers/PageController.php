<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function emergencyContacts()
    {
        $contacts = EmergencyContact::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->groupBy('type');

        return view('pages.emergency-contacts', compact('contacts'));
    }
}
