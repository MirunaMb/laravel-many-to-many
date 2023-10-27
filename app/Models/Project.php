<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'type_id',
        
    ];
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function getTypeBadges()
    {
        if (empty($this->type)) {
            return 'Empty Type';
        } else {
            return "<span class='badge' style='background-color: {$this->type->color}'>{$this->type->name}</span>";
        }
    }
    

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }

    public function getTechnologiesBadges(){
        if (empty($this->technologies)) {
            return 'Empty Tehnology';
        } else {
            $html = "";
            foreach ($this->technologies as $technology) {
                $html .= "<span class='badge' style=''>{$technology->name_technologies}</span>";
            }
            return $html;
        }
    }
   
}
