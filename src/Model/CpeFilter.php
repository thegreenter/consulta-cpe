<?php declare(strict_types=1);

namespace Greenter\Sunat\ConsultaCpe\Model;

use ArrayAccess;
use Greenter\Sunat\ConsultaCpe\ObjectSerializer;

/**
 * CpeFilter Class
 */
class CpeFilter implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'CpeFilter';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'num_ruc' => 'string',
        'cod_comp' => 'string',
        'numero_serie' => 'string',
        'numero' => 'string',
        'fecha_emision' => 'string',
        'monto' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var array<string, null>
      */
    protected static $openAPIFormats = [
        'num_ruc' => null,
        'cod_comp' => null,
        'numero_serie' => null,
        'numero' => null,
        'fecha_emision' => null,
        'monto' => null
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
        'num_ruc' => 'numRuc',
        'cod_comp' => 'codComp',
        'numero_serie' => 'numeroSerie',
        'numero' => 'numero',
        'fecha_emision' => 'fechaEmision',
        'monto' => 'monto'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'num_ruc' => 'setNumRuc',
        'cod_comp' => 'setCodComp',
        'numero_serie' => 'setNumeroSerie',
        'numero' => 'setNumero',
        'fecha_emision' => 'setFechaEmision',
        'monto' => 'setMonto'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'num_ruc' => 'getNumRuc',
        'cod_comp' => 'getCodComp',
        'numero_serie' => 'getNumeroSerie',
        'numero' => 'getNumero',
        'fecha_emision' => 'getFechaEmision',
        'monto' => 'getMonto'
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
        $this->container['num_ruc'] = isset($data['num_ruc']) ? $data['num_ruc'] : null;
        $this->container['cod_comp'] = isset($data['cod_comp']) ? $data['cod_comp'] : null;
        $this->container['numero_serie'] = isset($data['numero_serie']) ? $data['numero_serie'] : null;
        $this->container['numero'] = isset($data['numero']) ? $data['numero'] : null;
        $this->container['fecha_emision'] = isset($data['fecha_emision']) ? $data['fecha_emision'] : null;
        $this->container['monto'] = isset($data['monto']) ? $data['monto'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['num_ruc'] === null) {
            $invalidProperties[] = "'num_ruc' can't be null";
        }
        if ($this->container['cod_comp'] === null) {
            $invalidProperties[] = "'cod_comp' can't be null";
        }
        if ($this->container['numero_serie'] === null) {
            $invalidProperties[] = "'numero_serie' can't be null";
        }
        if ($this->container['numero'] === null) {
            $invalidProperties[] = "'numero' can't be null";
        }
        if ($this->container['fecha_emision'] === null) {
            $invalidProperties[] = "'fecha_emision' can't be null";
        }
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
     * Gets num_ruc
     *
     * @return string
     */
    public function getNumRuc()
    {
        return $this->container['num_ruc'];
    }

    /**
     * Sets num_ruc
     *
     * @param string $num_ruc Número de RUC emisor comprobante
     *
     * @return $this
     */
    public function setNumRuc($num_ruc)
    {
        $this->container['num_ruc'] = $num_ruc;

        return $this;
    }

    /**
     * Gets cod_comp
     *
     * @return string
     */
    public function getCodComp()
    {
        return $this->container['cod_comp'];
    }

    /**
     * Sets cod_comp
     *
     * @param string $cod_comp Código de tipo de comprobante
     *
     * @return $this
     */
    public function setCodComp($cod_comp)
    {
        $this->container['cod_comp'] = $cod_comp;

        return $this;
    }

    /**
     * Gets numero_serie
     *
     * @return string
     */
    public function getNumeroSerie()
    {
        return $this->container['numero_serie'];
    }

    /**
     * Sets numero_serie
     *
     * @param string $numero_serie Número de serie del comprobante
     *
     * @return $this
     */
    public function setNumeroSerie($numero_serie)
    {
        $this->container['numero_serie'] = $numero_serie;

        return $this;
    }

    /**
     * Gets numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->container['numero'];
    }

    /**
     * Sets numero
     *
     * @param string $numero Número del comprobante
     *
     * @return $this
     */
    public function setNumero($numero)
    {
        $this->container['numero'] = $numero;

        return $this;
    }

    /**
     * Gets fecha_emision
     *
     * @return string
     */
    public function getFechaEmision()
    {
        return $this->container['fecha_emision'];
    }

    /**
     * Sets fecha_emision
     *
     * @param string $fecha_emision Fecha de emisión del comprobante
     *
     * @return $this
     */
    public function setFechaEmision($fecha_emision)
    {
        $this->container['fecha_emision'] = $fecha_emision;

        return $this;
    }

    /**
     * Gets monto
     *
     * @return string|null
     */
    public function getMonto()
    {
        return $this->container['monto'];
    }

    /**
     * Sets monto
     *
     * @param string|null $monto Monto total del comprobante
     *
     * @return $this
     */
    public function setMonto($monto)
    {
        $this->container['monto'] = $monto;

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


