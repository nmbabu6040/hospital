<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\News;
use App\Models\Offer;
use App\Models\Package;
use App\Models\Test;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q'));
        $results = [];

        if (strlen($query) >= 2) {
            $results = $this->performSearch($query);
        }

        return view('front.search.index', compact('query', 'results'));
    }

    /**
     * Header dropdown-এর জন্য দ্রুত AJAX সার্চ — প্রতিটা ক্যাটাগরি থেকে অল্প কয়েকটা রেজাল্ট।
     */
    public function quick(Request $request)
    {
        $query = trim((string) $request->input('q'));

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = $this->performSearch($query, 4);

        return response()->json(['results' => $results]);
    }

    private function performSearch(string $query, int $limitPerType = 10): array
    {
        $like = '%' . $query . '%';
        $results = [];

        $doctors = Doctor::where('is_active', true)
            ->where(fn($q) => $q->where('name', 'like', $like)->orWhere('designation', 'like', $like))
            ->take($limitPerType)->get();

        foreach ($doctors as $doctor) {
            $results[] = [
                'type' => 'Doctor',
                'icon' => '👨‍⚕️',
                'title' => $doctor->name,
                'subtitle' => $doctor->designation,
                'url' => route('doctors.show', $doctor),
            ];
        }

        $departments = Department::where('name', 'like', $like)->take($limitPerType)->get();
        foreach ($departments as $department) {
            $results[] = [
                'type' => 'Department',
                'icon' => '🏥',
                'title' => $department->name,
                'subtitle' => 'Department',
                'url' => route('departments.show', $department),
            ];
        }

        $hospitals = Hospital::where('is_active', true)->where('name', 'like', $like)->take($limitPerType)->get();
        foreach ($hospitals as $hospital) {
            $results[] = [
                'type' => 'Hospital',
                'icon' => '🏨',
                'title' => $hospital->name,
                'subtitle' => $hospital->address,
                'url' => route('hospitals.show', $hospital),
            ];
        }

        $diagnostics = Diagnostic::where('is_active', true)->where('name', 'like', $like)->take($limitPerType)->get();
        foreach ($diagnostics as $diagnostic) {
            $results[] = [
                'type' => 'Diagnostic',
                'icon' => '🔬',
                'title' => $diagnostic->name,
                'subtitle' => $diagnostic->address,
                'url' => route('diagnostics.show', $diagnostic),
            ];
        }

        $packages = Package::where('name', 'like', $like)->take($limitPerType)->get();
        foreach ($packages as $package) {
            $results[] = [
                'type' => 'Package',
                'icon' => '📦',
                'title' => $package->name,
                'subtitle' => 'Tk ' . number_format($package->price),
                'url' => route('packages.show', $package),
            ];
        }

        $tests = Test::where('is_active', true)->where('name', 'like', $like)->take($limitPerType)->get();
        foreach ($tests as $test) {
            $results[] = [
                'type' => 'Test',
                'icon' => '🧪',
                'title' => $test->name,
                'subtitle' => 'Tk ' . number_format($test->price),
                'url' => route('tests.show', $test),
            ];
        }

        $news = News::where('title', 'like', $like)->take($limitPerType)->get();
        foreach ($news as $item) {
            $results[] = [
                'type' => 'News',
                'icon' => '📰',
                'title' => $item->title,
                'subtitle' => $item->published_at?->format('d M, Y'),
                'url' => route('news.show', $item),
            ];
        }

        $offers = Offer::where('title', 'like', $like)->take($limitPerType)->get();
        foreach ($offers as $offer) {
            $results[] = [
                'type' => 'Offer',
                'icon' => '🎁',
                'title' => $offer->title,
                'subtitle' => 'Offer',
                'url' => route('offers.index'),
            ];
        }

        return $results;
    }
}
