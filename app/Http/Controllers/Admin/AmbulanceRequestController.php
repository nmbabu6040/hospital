<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\AmbulanceRequest;
use Illuminate\Http\Request;

class AmbulanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = AmbulanceRequest::with('ambulance');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderByDesc('is_emergency')->latest()->paginate(20)->withQueryString();
        $availableAmbulances = Ambulance::where('status', 'available')->get();

        return view('admin.ambulance-requests.index', compact('requests', 'availableAmbulances'));
    }

    public function update(Request $request, AmbulanceRequest $ambulanceRequest)
    {
        $data = $request->validate([
            'ambulance_id' => ['nullable', 'exists:ambulances,id'],
            'status' => ['required', 'in:pending,assigned,on_the_way,completed,cancelled'],
        ]);

        if (! empty($data['ambulance_id']) && $data['status'] === 'assigned') {
            Ambulance::where('id', $data['ambulance_id'])->update(['status' => 'on_duty']);
        }

        if (in_array($data['status'], ['completed', 'cancelled']) && $ambulanceRequest->ambulance_id) {
            Ambulance::where('id', $ambulanceRequest->ambulance_id)->update(['status' => 'available']);
        }

        $ambulanceRequest->update($data);

        return back()->with('success', 'Request updated successfully.');
    }

    public function destroy(AmbulanceRequest $ambulanceRequest)
    {
        $ambulanceRequest->delete();

        return back()->with('success', 'Request deleted.');
    }
}
