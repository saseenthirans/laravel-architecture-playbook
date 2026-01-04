<?php

declare(strict_types=1);

namespace App\Domain\Project;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;

final class ProjectTaskStats
{
    private const CACHE_TTL_MINUTES = 10;

    public function completedTaskCount(int $projectId): int
    {
        return Cache::remember(
            $this->cacheKey($projectId),
            now()->addMinutes(self::CACHE_TTL_MINUTES),
            static fn (): int => Task::query()
                ->where('project_id', $projectId)
                ->where('status', 'completed')
                ->count()
        );
    }

    private function cacheKey(int $projectId): string
    {
        return "project:{$projectId}:completed_tasks_count";
    }
}
