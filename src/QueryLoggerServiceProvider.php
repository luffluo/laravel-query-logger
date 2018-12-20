<?php

namespace Luffluo\LaravelQueryLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

class QueryLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! config('app.query_logger', false)) {
            return;
        }

        Log::info(sprintf('=============== %s: %s ===============', request()->method(), request()->fullUrl()));

        DB::listen(function (QueryExecuted $query) {

            $sqlWithPlaceholders = str_replace(['%', '?'], ['%%', '%s'], $query->sql);

            $bindings = $query->connection->prepareBindings($query->bindings);

            $pdo = $query->connection->getPdo();

            $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));

            $duration = $this->formatDuration($query->time / 1000);

            Log::debug(sprintf('[%s] %s', $duration, $realSql));
        });
    }

    /**
     * @param float $seconds
     *
     * @return string
     */
    public function formatDuration($seconds)
    {
        // 微秒
        if ($seconds < 0.0001) {
            return round($seconds * 1000000) . 'μs';

        // 毫秒
        } elseif ($seconds < 1) {
            return round($seconds * 1000, 2) . 'ms';
        }

        // 秒
        return round($seconds, 2) . 's';
    }
}
