<?php

namespace Mantra\Routing;


abstract class RouteIdentifier {
    /**
     * Converts to base 64 the two elements that make this route unique.
     * @param  string $httpMethod   [description]
     * @param  string $urlPattern   [description]
     * @return string               [description]
     */
    public static function getIdentity(string $httpMethod, string $urlPattern) : string {
        return static::getIdentityFromUri($httpMethod . $urlPattern);
    }

    public static function getIdentityFromUri(string $string) : string {
        return base64_encode($string);
    }

}
?>
