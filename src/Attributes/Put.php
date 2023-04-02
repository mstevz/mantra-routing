<?php

namespace Mantra\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Put extends Route {

    /**
     * @param string $verb     [description]
     * @param string $urlPattern [description]
     */
    public function __construct(string $urlPattern){
        parent::__construct('put', $urlPattern);
    }

}

?>
