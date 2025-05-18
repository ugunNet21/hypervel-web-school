<?php

declare(strict_types=1);

namespace App\Traits;

use Hypervel\Support\Str; // fixed str bukan hyperf

trait UsesUuid
{
    /**
     * Initialize the UUID for the model.
     */
    public function initializeUsesUuid(): void
    {
        if (empty($this->{$this->getKeyName()})) {
            $this->{$this->getKeyName()} = (string) Str::uuid();
        }
    }

    /**
     * Override the create method to ensure UUID is set.
     */
    public static function create(array $attributes = []): static
    {
        $model = new static($attributes);
        $model->initializeUsesUuid();
        $model->save();
        return $model;
    }
}