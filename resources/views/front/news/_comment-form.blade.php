<form action="{{ route('comments.store', $news) }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="parent_id" value="{{ $parentId }}">

    {{-- Honeypot field — bot ফিল্ড ভরলে request reject হবে, মানুষ CSS দিয়ে এটা দেখবেই না --}}
    {{-- <div class="absolute -left-[9999px]" aria-hidden="true">
        <label>Website</label>
        <input type="text" name="website" tabindex="-1" autocomplete="off">
    </div> --}}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <input type="text" name="name" placeholder="আপনার নাম *" required value="{{ old('name') }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
        </div>
        <div>
            <input type="email" name="email" placeholder="আপনার ইমেইল *" required value="{{ old('email') }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
        </div>
    </div>

    <div>
        <textarea name="body" rows="3" placeholder="আপনার মন্তব্য লিখুন..." required
            class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand">{{ old('body') }}</textarea>
    </div>

    <button type="submit" class="btn-primary text-sm">{{ $parentId ? 'Reply Submit' : 'Submit Comment' }}</button>
</form>
