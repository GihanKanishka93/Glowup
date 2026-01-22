<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Builder::macro('filter', function (array $filters, array $allowed) {
            foreach ($filters as $field => $value) {
                if (!in_array($field, $allowed, true) || $value === null || $value === '') {
                    continue;
                }

                if (is_array($value)) {
                    if (array_is_list($value)) {
                        $this->whereIn($field, array_filter($value, fn ($entry) => $entry !== null && $entry !== ''));
                        continue;
                    }

                    $from = $value['from'] ?? null;
                    $to = $value['to'] ?? null;

                    if ($from) {
                        $this->whereDate($field, '>=', $from);
                    }

                    if ($to) {
                        $this->whereDate($field, '<=', $to);
                    }

                    continue;
                }

                if (is_string($value) && (str_ends_with($field, '_date') || $field === 'date')) {
                    $this->whereDate($field, $value);
                } else {
                    $this->where($field, $value);
                }
            }

            return $this;
        });

        Builder::macro('sort', function ($sort, array $allowed) {
            $sorts = $sort;

            if (is_string($sorts)) {
                $sorts = array_filter(explode(',', $sorts));
            }

            if (!is_array($sorts)) {
                return $this;
            }

            foreach ($sorts as $column) {
                $direction = 'asc';
                if (is_string($column) && str_starts_with($column, '-')) {
                    $direction = 'desc';
                    $column = substr($column, 1);
                }

                if (in_array($column, $allowed, true)) {
                    $this->orderBy($column, $direction);
                }
            }

            return $this;
        });

        Builder::macro('paginateRequest', function (?int $perPage = null) {
            $perPage = $perPage && $perPage > 0 ? $perPage : request()->integer('per_page', 15);

            return $this->paginate($perPage)->appends(request()->query());
        });
    }
}
