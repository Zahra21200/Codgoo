<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectAddons extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'project_addons';

    /**
     * Define the relationship with the project model.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Define the relationship with the Addon model.
     */
    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
