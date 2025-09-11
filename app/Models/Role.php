<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'parent_id',
        'description',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the parent role.
     */
    public function parent()
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }

    /**
     * Get the child roles.
     */
    public function children()
    {
        return $this->hasMany(Role::class, 'parent_id');
    }

    /**
     * Get the admins associated with this role.
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

    /**
     * Get all parents and children of the role (including nested ones).
     *
     * @return array
     */
    public function getHierarchy()
    {
        $parents = $this->getAllParents();
        $children = $this->getAllChildren();

        return [
            'parents' => $parents,
            'current' => $this,
            'children' => $children,
        ];
    }

    /**
     * Recursively get all parent roles.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAllParents()
    {
        $parents = collect();

        $current = $this;
        while ($current->parent) {
            $parents->push($current->parent);
            $current = $current->parent;
        }

        return $parents->reverse()->values();
    }

    /**
     * Recursively get all child roles.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAllChildren()
    {
        $children = collect();

        $this->load('children');
        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->getAllChildren());
        }

        return $children;
    }
}
