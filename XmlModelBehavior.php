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
     * Root element name
     *
     *
     * @var string
     */
    public $rootElement = 'root';
    public function asXml()
    {
        $fields = $this->owner->toArray();
        return ArrayToXml::convert($fields, $this->rootElement);
    }
}