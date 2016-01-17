<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /**
     * Relationship with the Endpoint model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function endpoints()
    {
        return $this->belongsToMany(Endpoint::class)->withPivot(['id']);
    }

    /**
     * Relationship with the Rule model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rules()
    {
        return $this->morphToMany(Rule::class, 'ruleable');
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof Endpoint) {
            return new FieldEndpoint($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}
