<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Localidade
{
    /**
    * 
    * @var integer
    */
    public $id;
    
    /**
    * 
    * @var string
    */
    public $local;

    /**
    * 
    * @var string
    */
    public $desc_especifica;

    /**
    * 
    * @var string
    */
    public $altitude;

    /**
    * 
    * @var string
    */
    public $latitude;

    /**
    * 
    * @var string
    */
    public $longitude;

    /**
     * 
     * @var InputFilterInterface
     */
    private $inputFilter;

    public function exchangeArray($data)
    {
        foreach($data as $attribute => $value){
            $this->$attribute = $value;
        }
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'local'=>$this->local,
            'desc_especifica'=>$this->desc_especifica,
            'altitude'=>$this->altitude,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude
        ];
    }
}
?>