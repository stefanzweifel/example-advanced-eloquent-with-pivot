<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    /**
     * Relationship with the Field model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function fields()
    {
        return $this->morphedByMany(Field::class, 'ruleable')->withPivot(["parameters"]);
    }

    /**
     * Relationship with the FieldEndpoint model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function fieldEndpoints()
    {
        return $this->morphedByMany(FieldEndpoint::class, 'ruleable');
    }
}
