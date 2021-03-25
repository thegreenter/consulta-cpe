<?php declare(strict_types=1);

namespace Greenter\Sunat\ConsultaCpe\Model;

use ArrayAccess;
use Greenter\Sunat\ConsultaCpe\ObjectSerializer;

/**
 * CpeStatus Class
 */
class CpeStatus implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'CpeStatus';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'estado_cp' => 'string',
        'estado_ruc' => 'string',
        'cond_domi_ruc' => 'string',
        'observaciones' => 'string[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var array<string, null>
      */
    protected static $openAPIFormats = [
        'estado_cp' => null,
        'estado_ruc' => null,
        'cond_domi_ruc' => null,
        'observaciones' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'estado_cp' => 'estadoCp',
        'estado_ruc' => 'estadoRuc',
        'cond_domi_ruc' => 'condDomiRuc',
        'observaciones' => 'Observaciones'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'estado_cp' => 'setEstadoCp',
        'estado_ruc' => 'setEstadoRuc',
        'cond_domi_ruc' => 'setCondDomiRuc',
        'observaciones' => 'setObservaciones'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'estado_cp' => 'getEstadoCp',
        'estado_ruc' => 'getEstadoRuc',
        'cond_domi_ruc' => 'getCondDomiRuc',
        'observaciones' => 'getObservaciones'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['estado_cp'] = isset($data['estado_cp']) ? $data['estado_cp'] : null;
        $this->container['estado_ruc'] = isset($data['estado_ruc']) ? $data['estado_ruc'] : null;
        $this->container['cond_domi_ruc'] = isset($data['cond_domi_ruc']) ? $data['cond_domi_ruc'] : null;
        $this->container['observaciones'] = isset($data['observaciones']) ? $data['observaciones'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets estado_cp
     *
     * @return string|null
     */
    public function getEstadoCp()
    {
        return $this->container['estado_cp'];
    }

    /**
     * Sets estado_cp
     *
     * @param string|null $estado_cp Estado del comprobante
     *
     * @return $this
     */
    public function setEstadoCp($estado_cp)
    {
        $this->container['estado_cp'] = $estado_cp;

        return $this;
    }

    /**
     * Gets estado_ruc
     *
     * @return string|null
     */
    public function getEstadoRuc()
    {
        return $this->container['estado_ruc'];
    }

    /**
     * Sets estado_ruc
     *
     * @param string|null $estado_ruc Estado del contribuyente
     *
     * @return $this
     */
    public function setEstadoRuc($estado_ruc)
    {
        $this->container['estado_ruc'] = $estado_ruc;

        return $this;
    }

    /**
     * Gets cond_domi_ruc
     *
     * @return string|null
     */
    public function getCondDomiRuc()
    {
        return $this->container['cond_domi_ruc'];
    }

    /**
     * Sets cond_domi_ruc
     *
     * @param string|null $cond_domi_ruc Condición Domiciliaria del Contribuyente
     *
     * @return $this
     */
    public function setCondDomiRuc($cond_domi_ruc)
    {
        $this->container['cond_domi_ruc'] = $cond_domi_ruc;

        return $this;
    }

    /**
     * Gets observaciones
     *
     * @return string[]|null
     */
    public function getObservaciones()
    {
        return $this->container['observaciones'];
    }

    /**
     * Sets observaciones
     *
     * @param string[]|null $observaciones Observaciones
     *
     * @return $this
     */
    public function setObservaciones($observaciones)
    {
        $this->container['observaciones'] = $observaciones;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer|null $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


