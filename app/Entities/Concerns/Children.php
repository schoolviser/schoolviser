<?php
namespace App\Entities\Concerns;

trait Children {

    public function scopeIsParent($query)
    {
        return $query->whereNull('parent_id');
    }
    
    public function children()
    {
        return (method_exists(self::class, 'getChildrenWith')) ? $this->HasMany(self::class, 'parent_id')->with($this->getChildrenWith()) : $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

}