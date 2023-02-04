<?php
declare(strict_types = 1);
/**
 * The file is part of xxx/xxx
 *
 *
 */

namespace dcr\Annotation\Mapping;

use Attribute;

/**
 * @Annotation
 * @Target({"ALL"})
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Middleware extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $middleware = '';

    public function __construct(...$value)
    {
        $this->bindMainProperty('middleware', $value);
        $this->middleware = $value;
    }
}
