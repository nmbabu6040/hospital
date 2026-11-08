<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodDonor;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{
    public function donors(Request $request)
    {
        $query = BloodDonor::query();

        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%'));
        }

        $donors = $query->latest()->paginate(20)->withQueryString();

        return view('admin.blood-bank.donors', compact('donors'));
    }

    public function toggleVerified(BloodDonor $donor)
    {
        $donor->update(['is_verified' => ! $donor->is_verified]);

        return back()->with('success', 'Donor verification status updated.');
    }

    public function toggleAvailable(BloodDonor $donor)
    {
        $donor->update(['is_available' => ! $donor->is_available]);

        return back()->with('success', 'Donor availability updated.');
    }

    public function destroyDonor(BloodDonor $donor)
    {
        $donor->delete();

        return back()->with('success', 'Donor removed.');
    }

    public function requests()
    {
        $requests = BloodRequest::latest()->paginate(20);

        return view('admin.blood-bank.requests', compact('requests'));
    }

    public function toggleFulfilled(BloodRequest $request)
    {
        $request->update(['is_fulfilled' => ! $request->is_fulfilled]);

        return back()->with('success', 'Request status updated.');
    }

    public function destroyRequest(BloodRequest $request)
    {
        $request->delete();

        return back()->with('success', 'Request removed.');
    }
}
