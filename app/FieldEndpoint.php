<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FieldEndpoint extends Pivot
{
    /**
     * Relationship with the Rule model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rules()
    {
        return $this->morphToMany(Rule::class, 'ruleable')->withPivot('parameters');
        ;
    }
}
