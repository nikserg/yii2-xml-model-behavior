<?php

namespace nikserg\yii2\XmlModelBehavior;

use Spatie\ArrayToXml\ArrayToXml;
use yii\base\Behavior;
use yii\base\Model;

/**
 * Class XmlModelBehavior
 *
 * @property Model $owner
 * @package nikserg\yii2\XmlModelBehavior
 */
class XmlModelBehavior extends Behavior
{
    /**
     * Название корневого элемента
     *
     *
     * @var string
     */
    public $rootElement = 'root';
    public function asXml()
    {
        $fields = $this->owner->toArray();
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
        return ArrayToXml::convert($fields, $this->rootElement);
    }
}