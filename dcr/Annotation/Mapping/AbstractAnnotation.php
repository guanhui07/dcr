<?php
declare(strict_types = 1);
/**
 * The file is part of Dcr/framework
 *
 *
 */

namespace Dcr\Annotation\Mapping;

abstract class AbstractAnnotation
{
    protected function formatParams($value): array
    {
        if (isset($value[0])) {
            $value = $value[0];
        }
        if (! is_array($value)) {
            $value = ['value' => $value];
        }
        return $value;
    }

    protected function bindMainProperty(string $key, array $value): void
    {
        $formattedValue = $this->formatParams($value);
        if (isset($formattedValue['value'])) {
            $this->{$key} = $formattedValue['value'];
        }
    }
}
