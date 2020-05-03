<?php

namespace BabDev\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

class RoutableLengthAwarePaginator extends LengthAwarePaginator
{
    protected static ?\Closure $currentRouteResolver = null;

    public static function currentRouteResolver(\Closure $resolver): void
    {
        static::$currentRouteResolver = $resolver;
    }

    public static function resolveCurrentRoute(): ?Route
    {
        if (static::$currentRouteResolver === null) {
            return null;
        }

        return \call_user_func(static::$currentRouteResolver);
    }

    /**
     * Get the URL for a given page number.
     *
     * @param int $page
     *
     * @return string
     */
    public function url($page)
    {
        $route = static::resolveCurrentRoute();

        if ($route === null) {
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

        if (\count($this->query) > 0) {
            $parameters = \array_merge($this->query, $parameters);
        }

        if ($page === 1) {
            return route($nonPaginatedRouteName, $parameters);
        }

        $parameters[$this->pageName] = $page;

        return route($paginatedRouteName, $parameters);
    }
}
