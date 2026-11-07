<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::latest()->paginate(20);

        return view('admin.journals.index', compact('journals'));
    }

    public function create()
    {
        $journal = new Journal();

        return view('admin.journals.form', compact('journal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'pdf_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $data['pdf_file'] = $request->file('pdf_file')->store('journals', 'public');

        Journal::create($data);

        return redirect()->route('admin.journals.index')->with('success', 'Journal added successfully.');
    }

    public function edit(Journal $journal)
    {
        return view('admin.journals.form', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($request->hasFile('pdf_file')) {
            Storage::disk('public')->delete($journal->pdf_file);
            $data['pdf_file'] = $request->file('pdf_file')->store('journals', 'public');
        }

        $journal->update($data);

        return redirect()->route('admin.journals.index')->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal)
    {
        Storage::disk('public')->delete($journal->pdf_file);
        $journal->delete();

        return back()->with('success', 'Journal deleted successfully.');
    }
}
