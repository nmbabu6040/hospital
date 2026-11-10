<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            if (auth('admin')->check()) {
                ActivityLog::record('created', class_basename($model), $model->id, self::activityLabel($model));
            }
        });

        static::updated(function ($model) {
            if (auth('admin')->check()) {
                ActivityLog::record('updated', class_basename($model), $model->id, self::activityLabel($model));
            }
        });

        static::deleted(function ($model) {
            if (auth('admin')->check()) {
                ActivityLog::record('deleted', class_basename($model), $model->id, self::activityLabel($model));
            }
        });
    }

    private static function activityLabel($model): ?string
    {
        foreach (['name', 'title', 'invoice_no', 'vehicle_no'] as $field) {
            if (isset($model->$field)) {
                return $model->$field;
            }
        }

        return null;
    }
}
