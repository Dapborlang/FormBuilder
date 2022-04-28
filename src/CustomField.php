<?php

namespace Rdmarwein\Formbuilder;


use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    public function FormMaster()
    {
       return $this->belongsTo('Rdmarwein\Formbuilder\FormMaster');
    }
}
