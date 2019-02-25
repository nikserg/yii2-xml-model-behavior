# yii2-xml-model-behavior
Behavior and trait to serialize model as XML

## Install
`composer require nikserg/yii2-xml-model-behavior`

## Usage

Core functionality is `$model->asXml()`, which returns XML string, representating 
object. To successfully use this, the `$model`'s class should satisfy conditions:
1. Extends `yii\base\Model`
2. Uses behavior `nikserg\yii2\XmlModelBehavior\XmlModelBehavior`
3. Uses trait `nikserg\yii2\XmlModelBehavior\XmlArrayableTrait`
4. Overrides `fields()` function to use underscore functionality 
(see in Explaining Example section). 

## Simple example better than long explaination

```
use Document;
use nikserg\yii2\XmlModelBehavior\XmlArrayableTrait;
use nikserg\yii2\XmlModelBehavior\XmlModelBehavior;
use yii\base\Model;
class File extends Model
{
    use XmlArrayableTrait;
    
    public $idFile = null;
    public $applicationVersion = null;
    public $formVersion = null;

    /**
     * 
     * @property Document $document
     */
    public $document = null;

    public function behaviors()
    {
        $return = parent::behaviors();
        $return[] = [
            'class'       => XmlModelBehavior::class,
            'rootElement' => 'File',
        ];
        return $return;
    }

    public function fields()
    {
        return [
            '_idFile'   => 'idFile',
            '_applicationVersion' => 'applicationVersion',
            '_formVersion' => 'formVersion',
            'document'  => 'document',
        ];
    }
}

class Document extends Model
{
    use XmlArrayableTrait;
    public $documentId = null;

    public function fields()
    {
        return [
            '_id'   => 'documentId',
        ];
    }
}

```

Result of calling `$file->asXml()`:

```
<File idFile="123" applicationVersion="CCWE_SEDSF_1.6" formVersion="1.02">
    <document id="123"/>
</File>
```

## Explaining example
As you can see, behavior adds only in root model. Trait should be added to root 
AND child models. 
Parameter `rootElement` can set the name of root XML element.
In `fields()` function, those attributes, which names starts with underscore `_`, 
would be transformed into XML attributes of element. Other attributes would be
children elements.

## Behind the scene

`nikserg\yii2\XmlModelBehavior\XmlModelBehavior` provides `$model->asXml()` 
function. In fact, it's just a wrapper around 
`Spatie\ArrayToXml\ArrayToXml\ArrayToXml::convert` function, which is not very 
interesting. Interesting part starts with nesting models. To support unserscore 
functionality, you must override `toArray()` function, which is impossible in
behavior. This is where trait comes in game.