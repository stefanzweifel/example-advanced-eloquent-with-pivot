<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    /**
     * Relationship with the Field model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class, 'fields_endpoints')->withPivot(['id']);
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof Field) {
            return new FieldEndpoint($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}
