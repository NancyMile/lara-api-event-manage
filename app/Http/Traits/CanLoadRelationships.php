<?php
namespace  App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships
{
    public function loadRelationships(Model|EloquentBuilder|QueryBuilder|HasMany  $for, ?array $relations = null) : Model|EloquentBuilder|QueryBuilder|HasMany
    {

        $relations = $relations ?? $this->relations ?? [];

        foreach($relations as $relation){
            $for->when(
                $this->shouldIncludeRelations($relation),
                //intsnaceof returns what is the class type of an specific object
                fn($q) =>  $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return  $for;
    }

    //helper
    protected function shouldIncludeRelations(string $relation): bool
    {
        $include = request()->query('include');

        if(!$include){
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        //dd($relations);
        return in_array($relation,$relations);

    }
}
