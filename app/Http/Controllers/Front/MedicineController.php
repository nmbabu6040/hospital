<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::where('is_active', true);

        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('name', 'like', '%' . $request->search . '%')->orWhere('generic_name', 'like', '%' . $request->search . '%'));
        }

        $medicines = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('front.pharmacy.index', compact('medicines'));
    }
}
