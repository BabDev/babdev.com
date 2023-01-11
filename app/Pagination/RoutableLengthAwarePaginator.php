<?php

namespace BabDev\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

/**
 * @phpstan-type RouteResolver \Closure(): ?Route
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
     * @phpstan-param RouteResolver $resolver
     */
    public static function currentRouteResolver(\Closure $resolver): void
    {
        static::$currentRouteResolver = $resolver;
    }

    public static function resolveCurrentRoute(): ?Route
    {
        if (static::$currentRouteResolver === null) {
            return null;
        }

        return (static::$currentRouteResolver)();
    }

    /**
     * Get the URL for a given page number.
     *
     * @param int $page
     */
    public function url($page): string
    {
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
