<?php

namespace Rdmarwein\Formbuilder;

use Illuminate\Database\Eloquent\Model;

class FormRole extends Model
{
    public function FormRoleName()
    {
       return $this->belongsTo('Rdmarwein\Formbuilder\FormRoleName','role','role');
    }
    
     public function User()
    {
       return $this->belongsTo('App\User');
    }
    
    
}
public function link()
    {
       return $this->hasMany('Rdmarwein\Formbuilder\FormMaster','role','role')->orderBy('id');
    }