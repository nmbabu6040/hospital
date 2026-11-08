<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;

class SlotService
{
    /**
     * একটা নির্দিষ্ট ডাক্তারের নির্দিষ্ট তারিখের জন্য সব স্লট (available ও booked) জেনারেট করে।
     *
     * @return array<int, array{time: string, end_time: string, formatted: string, available: bool, booked_count: int, max_patients: int}>
     */
    public static function generateSlotsFor(Doctor $doctor, string $date): array
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek; // 0 = Sunday

        // ডাক্তার সেদিন ছুটিতে আছেন কিনা চেক করো
        $onLeave = $doctor->leaves()->whereDate('leave_date', $date)->exists();
        if ($onLeave) {
            return [];
        }

        $schedules = $doctor->schedules()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        if ($schedules->isEmpty()) {
            return [];
        }

        // সেই তারিখে আগে থেকে বুক হওয়া সব স্লট গণনা করো
        $existingBookings = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('date', $date)
            ->where('status', '!=', 'Cancelled')
            ->whereNotNull('slot_time')
            ->get()
            ->groupBy(fn($appointment) => $appointment->slot_time)
            ->map(fn($group) => $group->count());

        $slots = [];

        foreach ($schedules as $schedule) {
            $start = Carbon::parse($date . ' ' . $schedule->start_time);
            $end = Carbon::parse($date . ' ' . $schedule->end_time);
            $duration = $schedule->slot_duration_minutes;

            $cursor = $start->copy();

            while ($cursor->lt($end)) {
                $slotEnd = $cursor->copy()->addMinutes($duration);
                if ($slotEnd->gt($end)) {
                    break;
                }

                $timeKey = $cursor->format('H:i:s');
                $bookedCount = $existingBookings->get($timeKey, 0);

                // অতীতের সময়ের স্লট বাদ দাও (আজকের তারিখ হলে)
                $isPast = $carbonDate->isToday() && $cursor->lt(now());

                $slots[] = [
                    'time' => $timeKey,
                    'end_time' => $slotEnd->format('H:i:s'),
                    'formatted' => $cursor->format('h:i A') . ' - ' . $slotEnd->format('h:i A'),
                    'available' => ! $isPast && $bookedCount < $schedule->max_patients_per_slot,
                    'booked_count' => $bookedCount,
                    'max_patients' => $schedule->max_patients_per_slot,
                ];

                $cursor->addMinutes($duration);
            }
        }

        return $slots;
    }

    /**
     * পরবর্তী ৩০ দিনের মধ্যে কোন কোন তারিখে ডাক্তার available আছেন তার তালিকা।
     */
    public static function availableDatesFor(Doctor $doctor, int $daysAhead = 30): array
    {
        $activeDays = $doctor->schedules()->where('is_active', true)->pluck('day_of_week')->unique()->toArray();

        if (empty($activeDays)) {
            return [];
        }

        $leaveDates = $doctor->leaves()
            ->whereBetween('leave_date', [now()->format('Y-m-d'), now()->addDays($daysAhead)->format('Y-m-d')])
            ->pluck('leave_date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();

        $dates = [];
        $cursor = now()->copy();

        for ($i = 0; $i < $daysAhead; $i++) {
            $dateStr = $cursor->format('Y-m-d');

            if (in_array($cursor->dayOfWeek, $activeDays) && ! in_array($dateStr, $leaveDates)) {
                $dates[] = $dateStr;
            }

            $cursor->addDay();
        }

        return $dates;
    }

    /**
     * পরবর্তী serial number জেনারেট করে (সেই ডাক্তার + তারিখের জন্য)।
     */
    public static function nextSerialNo(Doctor $doctor, string $date): string
    {
        $count = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('date', $date)
            ->where('status', '!=', 'Cancelled')
            ->count();

        return (string) ($count + 1);
    }
}
