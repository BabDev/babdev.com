<?php

namespace BabDev\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

/**
 * @phpstan-type RouteResolver \Closure(): ?Route
 * @phpstan-type PaginatorChecker \Closure(): bool
 *
 * @template TValue
 * @extends LengthAwarePaginator<TValue>
 */
class RoutableLengthAwarePaginator extends LengthAwarePaginator
{
    /**
     * @phpstan-var RouteResolver|null
     */
    protected static ?\Closure $currentRouteResolver = null;

    /**
     * @phpstan-var PaginatorChecker|null
     */
    protected static ?\Closure $paginatorChecker = null;

    /**
     * @phpstan-param RouteResolver $resolver
     */
    public static function currentRouteResolver(\Closure $resolver): void
    {
        static::$currentRouteResolver = $resolver;
    }

    /**
     * @phpstan-param PaginatorChecker $checker
     */
    public static function paginatorChecker(\Closure $checker): void
    {
        static::$paginatorChecker = $checker;
    }

    public static function resolveCurrentRoute(): ?Route
    {
        if (!static::$currentRouteResolver instanceof \Closure) {
            return null;
        }

        return (static::$currentRouteResolver)();
    }

    public static function shouldUsePaginator(): bool
    {
        if (!static::$paginatorChecker instanceof \Closure) {
            return false;
        }

        return (static::$paginatorChecker)();
    }

    /**
     * Get the URL for a given page number.
     *
     * @param int $page
     */
    public function url($page): string
    {
        if (!static::shouldUsePaginator()) {
            return parent::url($page);
        }

        $route = static::resolveCurrentRoute();

        if (!$route instanceof Route) {
            return parent::url($page);
        }

        $routeName = $route->action['as'] ?? null;

        if (empty($routeName)) {
            return parent::url($page);
        }

        $nonPaginatedRouteName = Str::before($routeName, '.paginated');
        $paginatedRouteName = $nonPaginatedRouteName . '.paginated';

        if ($page <= 0) {
            $page = 1;
        }

        $parameters = [];

        if ($this->query !== []) {
            $parameters = array_merge($this->query, $parameters);
        }

        if ($page === 1) {
            return route($nonPaginatedRouteName, $parameters);
        }

        $parameters[$this->pageName] = $page;

        return route($paginatedRouteName, $parameters);
    }
}
