<?php

namespace SlackUnfurl\Route;

abstract class RouteMatcher
{
    /** @var array */
    protected $routes;

    public function match(string $url): array
    {
        foreach ($this->getRoutes() as $route => $pattern) {
            if (preg_match("!{$pattern}!", $url, $matches)) {
                return [$route, $this->getNamedKeys($matches)];
            }
        }

        throw new RouteNotMatchedException("Route not matched for {$url}");
    }

    private function getNamedKeys(array $array): array
    {
        $namedKeys = array_filter(array_keys($array), function ($element) {
            return !is_numeric($element);
        });

        return array_intersect_key($array, array_flip($namedKeys));
    }

    abstract protected function getRoutes(): array;
}