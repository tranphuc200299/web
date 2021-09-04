<?php


namespace Develops\_R\Entities\Generator;


use Illuminate\Support\Str;

class FieldParams
{
    /** @var string */
    public $name;

    /** @var string */
    public $dbType;

    /** @var string */
    public $txtLabel;

    /** @var string */
    public $htmlType;

    /** @var string */
    public $valueList;

    /** @var string */
    public $validations;

    /** @var string */
    public $foreignTable;

    /** @var boolean */
    public $isUserId;

    /** @var string */
    public $nullable;

    /** @var string|null */
    public $txtFactoryFaker;

    /** @var boolean */
    public $unique;

    /** @var boolean */
    public $searchable;

    /** @var boolean */
    public $fillable;

    /** @var boolean */
    public $primary;

    /** @var boolean */
    public $inForm;

    /** @var boolean */
    public $inIndex;


    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            if (property_exists(self::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function getLabel()
    {
        if (!empty($this->txtLabel)) {
            return Str::ucfirst($this->txtLabel);
        }

        return Str::ucfirst($this->name);
    }

    public function getValueList()
    {
        $items = [];
        if ($this->valueList) {
            foreach (explode("\n", $this->valueList) as $line) {
                $line = trim($line);
                $data = explode(":", $line);
                if (sizeof($data) == 2) {
                    $items[] = [
                        'key' => $data[0],
                        'label' => $data[1],
                    ];
                }
            }
        }

        return $items;
    }
}
