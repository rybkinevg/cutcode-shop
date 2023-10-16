<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected string $sluggableField = 'title';

    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = $model->slug ?? str($model->{$this->sluggableField})->slug();
        });
    }
}