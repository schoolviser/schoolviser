<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use \Carbon\Carbon;

class LeftScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['MarkAsLeft', 'UnMarkAsLeft', 'WithLeft', 'WithoutLeft', 'OnlyLeft'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedLeftOnColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "deleted at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    protected function getLeftOnColumn(Builder $builder)
    {
        if (count($builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedLeftOnColumn();
        }

        return $builder->getModel()->getLeftOnColumn();
    }

    /**
     * Add the markAsLeft extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addMarkAsLeft(Builder $builder)
    {
        $builder->macro('markAsLeft', function (Builder $builder) {
            return $builder->update([$builder->getModel()->getLeftOnColumn() => Carbon::now()]);
        });
    }

    /**
     * Add the unmakeAsLeft extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addUnMarkAsLeft(Builder $builder)
    {
        $builder->macro('unMarkAsLeft', function (Builder $builder) {
            $builder->withArchived();

            return $builder->update([$builder->getModel()->getLeftOnColumn() => null]);
        });
    }

    /**
     * Add the with-left extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithLeft(Builder $builder)
    {
        $builder->macro('withLeft', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-left extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutLeft(Builder $builder)
    {
        $builder->macro('withoutLeft', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedLeftOnColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-left extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyLeft(Builder $builder)
    {
        $builder->macro('onlyLeft', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedLeftOnColumn()
            );

            return $builder;
        });
    }
}
