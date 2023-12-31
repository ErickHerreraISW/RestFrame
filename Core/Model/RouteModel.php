<?php

namespace Core\Model;

class RouteModel {

    /**
     * @var string
     */
    private string $route_url;

    /**
     * @var string
     */
    private string $route_http_method;

    /**
     * @var string
     */
    private string $route_class_obj;

    /**
     * @var string
     */
    private string $route_method_name;

    /**
     * @var string|null
     */
    private ?string $route_middleware;

    /**
     * @return string
     */
    public function getRouteUrl(): string
    {
        return $this->route_url;
    }

    /**
     * @param string $route_url
     * @return RouteModel
     */
    public function setRouteUrl(string $route_url): RouteModel
    {
        $this->route_url = $route_url;
        return $this;
    }

    /**
     * @return string
     */
    public function getRouteHttpMethod(): string
    {
        return $this->route_http_method;
    }

    /**
     * @param string $route_http_method
     * @return RouteModel
     */
    public function setRouteHttpMethod(string $route_http_method): RouteModel
    {
        $this->route_http_method = $route_http_method;
        return $this;
    }

    /**
     * @return string
     */
    public function getRouteClassObj(): string
    {
        return $this->route_class_obj;
    }

    /**
     * @param string $route_class_obj
     * @return RouteModel
     */
    public function setRouteClassObj(string $route_class_obj): RouteModel
    {
        $this->route_class_obj = $route_class_obj;
        return $this;
    }

    /**
     * @return string
     */
    public function getRouteMethodName(): string
    {
        return $this->route_method_name;
    }

    /**
     * @param string $route_method_name
     * @return RouteModel
     */
    public function setRouteMethodName(string $route_method_name): RouteModel
    {
        $this->route_method_name = $route_method_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRouteMiddleware(): ?string
    {
        return $this->route_middleware;
    }

    /**
     * @param string|null $route_middleware
     * @return RouteModel
     */
    public function setRouteMiddleware(?string $route_middleware): RouteModel
    {
        $this->route_middleware = $route_middleware;
        return $this;
    }
}