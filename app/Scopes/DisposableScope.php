<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use \Carbon\Carbon;

class DisposableScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['Dispose', 'Undispose', 'WithDisposed', 'WithoutDisposed', 'OnlyDisposed'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedDisposedOnColumn());
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
    protected function getDisposedOnColumn(Builder $builder)
    {
        if (count($builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedDisposedOnColumn();
        }

        return $builder->getModel()->getDisposedOnColumn();
    }

    /**
     * Add the archive extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addDispose(Builder $builder)
    {
        $builder->macro('dispose', function (Builder $builder) {
            return $builder->update([$builder->getModel()->getDisposedOnColumn() => Carbon::now()]);
        });
    }

    /**
     * Add the unarchive extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addUndispose(Builder $builder)
    {
        $builder->macro('unarchive', function (Builder $builder) {
            $builder->WithDisposed();

            return $builder->update([$builder->getModel()->getDisposedOnColumn() => null]);
        });
    }

    /**
     * Add the with-archived extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithDisposed(Builder $builder)
    {
        $builder->macro('withDisposed', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-archived extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutDisposed(Builder $builder)
    {
        $builder->macro('withoutDisposed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedDisposedOnColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-disposed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyDisposed(Builder $builder)
    {
        $builder->macro('onlyDisposed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedDisposedOnColumn()
            );

            return $builder;
        });
    }
}
