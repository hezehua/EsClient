<?php

namespace EsClient\EndPoints;

abstract class EndPoint {

    //
    const HEAD      = 'head';
    //
    const GET       = 'get';
    //
    const POST      = 'post';
    //
    const DELETE    = 'delete';

    //
    const APIS = [
        '_search',
        '_bulk',
        '_mapping'
    ];

    public static $index;

    public static $type;

    public static $headers;

    public $method;

    public $uri;

    public $params;

    public $body;

    public function setHeaders($headers) {
        self::$headers = $headers;
    }

    abstract public function setMethod();

    abstract public function setUri();

    abstract public function setParams();

    abstract public function setBody();

    public function setIndex($index) {
        self::$index = trim($index);
        return $this;
    }

    public function setType($type) {
        self::$type = trim($type);
        return $this;
    }

    public function getType() {
        return self::$type;
    }

    public function getIndex() {
        return self::$index;
    }
}