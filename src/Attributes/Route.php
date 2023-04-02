<?php

namespace Mantra\Routing\Attributes;

use Attribute;
use Mantra\Routing\UriVariable;

/**
 * Attribute to generate a Route method handler
 * 
 */
#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Route {

    private String $verb;
    private String $urlPattern;

    /**
     * @param string $verb     [description]
     * @param string $customUri [description]
     */
    public function __construct(string $verb, string $customUri){
        $this->verb = $verb;
        $this->urlPattern = $this->convertToRegularExp($customUri);
    }

    /**
     * Gets the Route Method/Verb
     *
     * @return void
     */
    public function getVerb(){
        return $this->verb;
    }

    /**
     * Returns the regelar expression url
     *
     * @return void
     */
    public function getUrlPattern(){
        return $this->urlPattern;
    }

    /**
     * Converts readable Mantra url pattern into a regular expression one.
     *
     * @param string $customUri
     * @return string
     */
    private function convertToRegularExp(string $customUri) : string {
        
        $pattern = '/\{\w+\:{0,1}\w+\}|\{\w+\:{0,1}\w+\(\d\,\d\)\}/';

        $variable = [];
        $urlPattern = $customUri;

        preg_match_all($pattern, $customUri, $matches, \PREG_PATTERN_ORDER);
        
        if($matches){
            $matches = $matches[0];
        }
        
        for($i = 0; $i < count($matches); $i++){
            $variable[$i] = preg_replace('/\{|\}/', '', $matches[$i]);    
            $variable[$i] = (new UriVariable($variable[$i]))->getAsRegularExpression();

            $urlPattern = str_replace($matches[$i], $variable[$i], $urlPattern);
        }
        
        return '/^' . str_replace('/', '\/', $urlPattern) . '$/';;
    }

}

?>
