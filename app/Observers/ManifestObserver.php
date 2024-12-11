<?php

namespace App\Observers;

use App\Models\Manifest;
use Illuminate\Support\Facades\DB;

class ManifestObserver
{
    /**
     * Handle the Manifest "created" event.
     */
    public function created(Manifest $manifest): void
    {
        DB::table('manifest_logs')->insert([
            'manifest_id' => $manifest->id,
            'action' => 'created',
            'modified_fields' => json_encode($manifest->getDirty()),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the Manifest "updated" event.
     */
    public function updated(Manifest $manifest): void
    {
        DB::table('manifest_logs')->insert([
            'manifest_id' => $manifest->id,
            'action' => 'updated',
            'modified_fields' => json_encode($manifest->getDirty()),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the Manifest "deleted" event.
     */
    public function deleted(Manifest $manifest): void
    {
        DB::table('manifest_logs')->insert([
            'manifest_id' => $manifest->id,
            'action' => 'deleted',
            'modified_fields' => json_encode($manifest->getDirty()),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the Manifest "restored" event.
     */
    public function restored(Manifest $manifest): void
    {
        //
    }

    /**
     * Handle the Manifest "force deleted" event.
     */
    public function forceDeleted(Manifest $manifest): void
    {
        //
    }
}
