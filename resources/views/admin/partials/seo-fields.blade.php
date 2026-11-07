<div x-data="{ open: false }" class="border border-gray-200 rounded-md">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            SEO Settings (ঐচ্ছিক)
        </span>
        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" x-cloak class="px-4 pb-4 space-y-3 border-t border-gray-100">
        <div class="pt-3">
            <label class="block text-xs font-medium mb-1 text-gray-600">Meta Title (ফাঁকা রাখলে পেজের নাম ব্যবহার
                হবে)</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $model->meta_title ?? '') }}"
                maxlength="255" class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium mb-1 text-gray-600">Meta Description (Google সার্চ রেজাল্টে দেখাবে,
                সর্বোচ্চ ১৬০ অক্ষর ভালো)</label>
            <textarea name="meta_description" rows="2" maxlength="500"
                class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">{{ old('meta_description', $model->meta_description ?? '') }}</textarea>
        </div>
    </div>
</div>
