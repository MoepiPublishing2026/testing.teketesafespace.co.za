<?php

namespace App\Support;

/**
 * Folders that may still hold REPORT EVIDENCE from before uploads moved to the private disk.
 * (Profile-picture folders live in AvatarStore::legacyDirectories().)
 */
class LegacyUploadFolders
{
    /** @return string[] */
    public static function evidence(): array
    {
        return [
            storage_path('app/public/reports'),
            public_path('storage/reports'),
            public_path('public_old/storage/reports'),
            storage_path('reports'),
            // Older client uploads were stored as uploads/report-<time>-<uuid>.<ext>
            storage_path('app/public/uploads'),
            public_path('storage/uploads'),
        ];
    }
}
