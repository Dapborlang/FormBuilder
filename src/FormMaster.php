<?php

namespace Rdmarwein\Formbuilder;

use Illuminate\Database\Eloquent\Model;

class FormMaster extends Model
{
    public function FormRoleName()
    {
       return $this->belongsTo('Rdmarwein\Formbuilder\FormRoleName','role','role');
    }
}
