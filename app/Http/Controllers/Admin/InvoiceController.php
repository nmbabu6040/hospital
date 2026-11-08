<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Hospital;
use App\Models\Invoice;
use App\Models\Package;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_no', 'like', '%' . $request->search . '%')
                    ->orWhere('patient_name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        $invoices = $query->latest()->paginate(20)->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $invoice = new Invoice();
        $hospitals = Hospital::orderBy('name')->get();
        $packages = Package::orderBy('name')->get();
        $appointments = Appointment::with('doctor')->latest()->take(50)->get();

        return view('admin.invoices.form', compact('invoice', 'hospitals', 'packages', 'appointments'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['invoice_no'] = Invoice::generateInvoiceNo();
        $data['created_by'] = auth('admin')->id();

        $invoice = Invoice::create($data);

        $this->saveItems($request, $invoice);
        $invoice->recalculateTotal();

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items', 'appointment', 'package', 'hospital');

        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $hospitals = Hospital::orderBy('name')->get();
        $packages = Package::orderBy('name')->get();
        $appointments = Appointment::with('doctor')->latest()->take(50)->get();

        return view('admin.invoices.form', compact('invoice', 'hospitals', 'packages', 'appointments'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validateData($request);
        $invoice->update($data);

        $invoice->items()->delete();
        $this->saveItems($request, $invoice);
        $invoice->recalculateTotal();

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    private function saveItems(Request $request, Invoice $invoice): void
    {
        $names = $request->input('item_name', []);
        $quantities = $request->input('quantity', []);
        $prices = $request->input('unit_price', []);

        foreach ($names as $index => $name) {
            if (trim($name) === '') {
                continue;
            }

            $qty = (int) ($quantities[$index] ?? 1);
            $price = (float) ($prices[$index] ?? 0);

            $invoice->items()->create([
                'item_name' => $name,
                'quantity' => $qty,
                'unit_price' => $price,
                'line_total' => $qty * $price,
                'sort_order' => $index,
            ]);
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:unpaid,paid,partial'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'invoice_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'item_name.*' => ['nullable', 'string', 'max:255'],
            'quantity.*' => ['nullable', 'integer', 'min:1'],
            'unit_price.*' => ['nullable', 'numeric', 'min:0'],
        ]) + ['discount' => $request->input('discount', 0)];
    }
}
