<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineSaleController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicineSale::with('items');

        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('sale_no', 'like', '%' . $request->search . '%')->orWhere('customer_name', 'like', '%' . $request->search . '%'));
        }

        $sales = $query->latest()->paginate(20)->withQueryString();

        $todayTotal = MedicineSale::whereDate('created_at', now()->format('Y-m-d'))->sum('grand_total');

        return view('admin.medicine-sales.index', compact('sales', 'todayTotal'));
    }

    public function create()
    {
        $medicines = Medicine::where('is_active', true)->where('stock_quantity', '>', 0)->orderBy('name')->get();

        return view('admin.medicine-sales.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'medicine_id' => ['required', 'array', 'min:1'],
            'medicine_id.*' => ['required', 'exists:medicines,id'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($request) {
            $sale = MedicineSale::create([
                'sale_no' => MedicineSale::generateSaleNo(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'discount' => $request->input('discount', 0),
                'sold_by' => auth('admin')->id(),
            ]);

            $total = 0;

            foreach ($request->medicine_id as $index => $medicineId) {
                $medicine = Medicine::findOrFail($medicineId);
                $qty = (int) $request->quantity[$index];

                if ($medicine->stock_quantity < $qty) {
                    throw new \Exception('Insufficient stock for ' . $medicine->name);
                }

                $lineTotal = $medicine->price * $qty;
                $total += $lineTotal;

                $sale->items()->create([
                    'medicine_id' => $medicine->id,
                    'medicine_name' => $medicine->name,
                    'quantity' => $qty,
                    'unit_price' => $medicine->price,
                    'line_total' => $lineTotal,
                ]);

                $medicine->decrement('stock_quantity', $qty);
            }

            $sale->update([
                'total_amount' => $total,
                'grand_total' => max(0, $total - $sale->discount),
            ]);
        });

        return redirect()->route('admin.medicine-sales.index')->with('success', 'Sale recorded successfully. Stock updated.');
    }

    public function show(MedicineSale $medicineSale)
    {
        $medicineSale->load('items');

        return view('admin.medicine-sales.show', compact('medicineSale'));
    }
}
