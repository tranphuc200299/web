<?php


namespace Develops\_R\Entities\Generator;


use Illuminate\Support\Str;

class RelationParams
{
    /**
     * @var string
     */
    public $relationType;

    /**
     * @var string
     */
    public $foreignModule;

    /**
     * @var string
     */
    public $foreignModel;

    /**
     * @var string
     */
    public $foreignTable;

    /**
     * @var string
     */
    public $foreignKey;

    /**
     * @var string
     */
    public $localKey;

    /**
     * @var string
     */
    public $displayName;

    /**
     * @var string
     */
    public $displayField;

    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            if (property_exists(self::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function getRelationName()
    {
        if ($this->isSingleRelation()) {
            return Str::lower($this->foreignModel);
        }

        return Str::plural(Str::lower($this->foreignModel));
    }

    public function getRelationRoute()
    {
        return Str::plural(Str::lower($this->foreignModel));
    }

    public function getNameSpace(){
        return 'Modules\\'.$this->foreignModule.'\\Entities\\Models\\'.$this->foreignModel.'Model';
    }

    public function isHasOne()
    {
        return $this->relationType == '1t1_has_one';
    }

    public function isBelongsToOneOne()
    {
        return $this->relationType == '1t1_belongs_to';
    }

    public function isHasMany()
    {
        return $this->relationType == 'mt1_has_many';
    }

    public function isBelongsToManyOne()
    {
        return $this->relationType == 'mt1_belongs_to';
    }

    public function isBelongsToMany()
    {
        return $this->relationType == 'mtm_belongs_to_many';
    }

    public function isSingleRelation()
    {
        return $this->isHasOne() || $this->isBelongsToOneOne() || $this->isBelongsToManyOne();
    }
}
