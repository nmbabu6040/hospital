<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorReview;
use Illuminate\Http\Request;

class DoctorReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = DoctorReview::with('doctor');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();

        $counts = [
            'pending' => DoctorReview::where('status', 'pending')->count(),
            'approved' => DoctorReview::where('status', 'approved')->count(),
            'rejected' => DoctorReview::where('status', 'rejected')->count(),
        ];

        return view('admin.doctor-reviews.index', compact('reviews', 'counts'));
    }

    public function approve(DoctorReview $doctorReview)
    {
        $doctorReview->update(['status' => 'approved']);

        return back()->with('success', 'Review approved.');
    }

    public function reject(DoctorReview $doctorReview)
    {
        $doctorReview->update(['status' => 'rejected']);

        return back()->with('success', 'Review rejected.');
    }

    public function destroy(DoctorReview $doctorReview)
    {
        $doctorReview->delete();

        return back()->with('success', 'Review deleted.');
    }
}
