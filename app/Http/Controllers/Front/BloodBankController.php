<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BloodDonor;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{
    public function index(Request $request)
    {
        $query = BloodDonor::where('is_available', true);

        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }

        if ($request->filled('district')) {
            $query->where('district', 'like', '%' . $request->district . '%');
        }

        $donors = $query->orderByDesc('is_verified')->orderBy('name')->paginate(20)->withQueryString();

        $openRequests = BloodRequest::where('is_fulfilled', false)
            ->where('needed_by_date', '>=', now()->format('Y-m-d'))
            ->latest()
            ->take(5)
            ->get();

        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        return view('front.blood-bank.index', compact('donors', 'openRequests', 'bloodGroups'));
    }

    public function createDonor()
    {
        $patient = auth('patient')->user();

        return view('front.blood-bank.register', compact('patient'));
    }

    public function storeDonor(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'district' => ['required', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:255'],
            'last_donation_date' => ['nullable', 'date', 'before_or_equal:today'],
            'age' => ['nullable', 'integer', 'min:18', 'max:65'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
        ]);

        if (auth('patient')->check()) {
            $data['patient_id'] = auth('patient')->id();
        }

        $data['is_available'] = true;

        BloodDonor::create($data);

        return redirect()->route('blood-bank.index')->with('success', 'ধন্যবাদ! আপনি সফলভাবে ব্লাড ডোনার হিসেবে নিবন্ধিত হয়েছেন। আপনার মহানুভবতা কারো জীবন বাঁচাতে পারে।');
    }

    public function createRequest()
    {
        return view('front.blood-bank.request-create');
    }

    public function storeRequest(Request $request)
    {
        $data = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'bags_needed' => ['required', 'integer', 'min:1', 'max:20'],
            'hospital_name' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:100'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'needed_by_date' => ['required', 'date', 'after_or_equal:today'],
            'additional_info' => ['nullable', 'string', 'max:1000'],
        ]);

        BloodRequest::create($data);

        return redirect()->route('blood-bank.index')->with('success', 'আপনার রক্তের জন্য রিকোয়েস্ট পোস্ট করা হয়েছে। Donor-রা আপনার সাথে যোগাযোগ করবেন।');
    }
}
