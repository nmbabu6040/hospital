@extends('layouts.app')

@section('title', __('site.book_appointment'))

@section('content')
    <section class="max-w-2xl mx-auto px-4 py-10" x-data="appointmentForm()">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-center">{{ __('site.book_appointment') }}</h1>

        @if ($patient)
            <div
                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md px-4 py-3 mb-5 text-sm">
                আপনি <strong>{{ $patient->name }}</strong> হিসেবে লগইন করা আছেন। <a href="{{ route('patient.dashboard') }}"
                    class="text-brand hover:underline">আমার অ্যাকাউন্টে যান</a>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointment.store') }}" method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.full_name') }} <span
                        class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $patient->name ?? '') }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.phone') }} <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.select_doctor') }} <span
                        class="text-red-500">*</span></label>
                <select name="doctor_id" x-model="doctorId" @change="onDoctorChange()" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                    <option value="">-- {{ __('site.select_doctor') }} --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ old('doctor_id', $selectedDoctor) == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} ({{ $doctor->department?->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- যদি এই ডাক্তারের Schedule সেট করা থাকে: তারিখ ও সময় পিকার দেখাবে --}}
            <template x-if="doctorId && hasSchedule">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">পছন্দের তারিখ বেছে নিন <span
                                class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="d in availableDates" :key="d.date">
                                <button type="button" @click="selectDate(d.date)"
                                    :class="selectedDate === d.date ? 'bg-brand text-white' :
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-3 py-2 rounded-md text-xs font-medium transition">
                                    <span x-text="d.label"></span>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="date" :value="selectedDate">
                    </div>

                    <template x-if="selectedDate">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">পছন্দের সময় বেছে নিন <span
                                    class="text-red-500">*</span></label>
                            <template x-if="slots.length === 0">
                                <p class="text-sm text-amber-600">এই তারিখে কোনো স্লট পাওয়া যায়নি।</p>
                            </template>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                <template x-for="slot in slots" :key="slot.time">
                                    <button type="button" @click="slot.available && selectSlot(slot)"
                                        :disabled="!slot.available"
                                        :class="{
                                            'bg-brand text-white': selectedSlot && selectedSlot.time === slot.time,
                                            'bg-gray-100 text-gray-700 hover:bg-gray-200': slot.available && (!
                                                selectedSlot || selectedSlot.time !== slot.time),
                                            'bg-gray-50 text-gray-300 cursor-not-allowed line-through': !slot.available
                                        }"
                                        class="px-3 py-2.5 rounded-md text-xs font-medium transition">
                                        <span x-text="slot.formatted"></span>
                                    </button>
                                </template>
                            </div>
                            <input type="hidden" name="slot_time" :value="selectedSlot ? selectedSlot.time : ''">
                            <input type="hidden" name="slot_end_time" :value="selectedSlot ? selectedSlot.end_time : ''">
                        </div>
                    </template>
                </div>
            </template>

            {{-- যদি এই ডাক্তারের কোনো Schedule সেট করা না থাকে: সাধারণ তারিখ ইনপুট (fallback) --}}
            <template x-if="doctorId && !hasSchedule">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.preferred_date') }} <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="date" x-model="fallbackDate" min="{{ date('Y-m-d') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                    <p class="text-xs text-gray-400 mt-1">এই ডাক্তারের জন্য এখনো নির্দিষ্ট সময়সূচি দেওয়া হয়নি। আপনার
                        পছন্দের তারিখ দিন, আমরা ফোনে যোগাযোগ করে সময় জানিয়ে দেবো।</p>
                </div>
            </template>

            {{-- কোনো ডাক্তার সিলেক্ট না করলে, ডিফল্ট তারিখ ইনপুট --}}
            <template x-if="!doctorId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.preferred_date') }} <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="date" x-model="fallbackDate" min="{{ date('Y-m-d') }}" required
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
                </div>
            </template>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('site.message') }}</label>
                <textarea name="message" rows="4"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">{{ old('message') }}</textarea>
            </div>

            <button type="submit" :disabled="doctorId && hasSchedule && !selectedSlot"
                :class="(doctorId && hasSchedule && !selectedSlot) ? 'opacity-50 cursor-not-allowed' : ''"
                class="btn-primary w-full">{{ __('site.submit') }}</button>
        </form>
    </section>

    <script>
        function appointmentForm() {
            return {
                scheduleData: @json($doctorScheduleData),
                doctorId: '{{ old('doctor_id', $selectedDoctor) }}',
                hasSchedule: false,
                availableDates: [],
                selectedDate: '',
                slots: [],
                selectedSlot: null,
                fallbackDate: '',

                init() {
                    if (this.doctorId) {
                        this.onDoctorChange();
                    }
                },

                onDoctorChange() {
                    this.selectedDate = '';
                    this.slots = [];
                    this.selectedSlot = null;
                    this.availableDates = [];
                    this.fallbackDate = '';

                    if (!this.doctorId || !this.scheduleData[this.doctorId]) {
                        this.hasSchedule = false;
                        return;
                    }

                    const data = this.scheduleData[this.doctorId];
                    this.hasSchedule = data.hasSchedule;
                    this.availableDates = data.dates;
                },

                selectDate(date) {
                    this.selectedDate = date;
                    this.selectedSlot = null;
                    this.slots = this.scheduleData[this.doctorId].slotsByDate[date] || [];
                },

                selectSlot(slot) {
                    this.selectedSlot = slot;
                },
            };
        }
    </script>
@endsection
