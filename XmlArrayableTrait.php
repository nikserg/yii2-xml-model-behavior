<?php

namespace nikserg\yii2\XmlModelBehavior;

use Spatie\ArrayToXml\ArrayToXml;
use yii\base\ArrayableTrait;
use yii\base\Behavior;
use yii\base\Model;


/**
 * Trait XmlArrayableTrait
 *
 * @package nikserg\yii2\XmlModelBehavior
 */
trait XmlArrayableTrait
{
    use ArrayableTrait;

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $fields = parent::toArray($fields, $expand, $recursive);
        $attributes = [];
        foreach ($fields as $fieldName => $fieldValue) {
            if (strpos($fieldName, '_') === 0) {
                $attributes[ substr($fieldName, 1) ] = $fieldValue;
                unset($fields[$fieldName]);
            }
        }
        if (!empty($attributes)) {
            $fields['_attributes'] = $attributes;
        }
        return $fields;
    }
}