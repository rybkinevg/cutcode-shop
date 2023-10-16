<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    private int $iterator = 1;

    protected function getSlugFrom(): string
    {
        return 'title';
    }

    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = $model->makeUniqueSlug($model);
        });
    }

    protected function makeUniqueSlug(Model $model): string
    {
        // TODO: allocates too much memory when loops over 100+ items
        do {
            $slug = $this->makeSlug($model);

            $slug = $this->isSlugAlreadyExists($model, $slug)
                ? $this->makeIncrementedSlug($slug)
                : $slug;
        } while ($this->isSlugAlreadyExists($model, $slug));

        return $slug;
    }

    protected function isSlugAlreadyExists(Model $model, string $slug): bool
    {
        return $model::query()
            ->where('slug', $slug)
            ->exists();
    }

    protected function makeSlug(Model $model): string
    {
        return $model->slug ?? str($model->{$model->getSlugFrom()})->slug()->value();
    }

    protected function makeIncrementedSlug(string $slug): string
    {
        return $slug . '-' . $this->iterator++;
    }
}
