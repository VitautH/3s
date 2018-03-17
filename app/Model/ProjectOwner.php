<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProjectOwner extends Model
{
    protected $table = 'project_owners';

    public function getTable()
    {
        return $this->table;
    }
}
