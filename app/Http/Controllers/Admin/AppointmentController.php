<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $query = Appointment::with(['doctor', 'branch']);
        $admin = auth('admin')->user();

        if ($admin->isBranchAdmin() && $admin->branch_id) {
            $query->where('branch_id', $admin->branch_id);
        }

        $appointments = $query->latest()->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeBranchAccess($appointment);

        $request->validate([
            'status' => ['required', 'in:Pending,Confirmed,Cancelled'],
        ]);

        $appointment->update(['status' => $request->status]);

        \App\Services\NotificationService::sendAppointmentStatusUpdateToPatient($appointment);

        return back()->with('success', 'Appointment status updated and patient notified.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorizeBranchAccess($appointment);

        $admin = auth('admin')->user();
        if (! $admin->canDelete()) {
            abort(403, 'Editors are not allowed to delete records.');
        }

        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }

    private function authorizeBranchAccess(Appointment $appointment): void
    {
        $admin = auth('admin')->user();

        if ($admin->isBranchAdmin() && $admin->branch_id && $appointment->branch_id !== $admin->branch_id) {
            abort(403, 'You can only manage appointments from your own branch.');
        }
    }
}
