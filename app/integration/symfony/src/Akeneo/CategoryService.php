<?php

declare(strict_types=1);

namespace App\Akeneo;

class CategoryService extends AkeneoService
{
    /**
     * Array like this:
     * [
     *     'code'   => 'winter_collection',
     *     'parent' => 'master',
     *     'labels' => [
     *         'en_US' => 'Winter collection',
     *         'fr_FR' => 'Collection hiver',
     *     ]
     * ].
     */
    public function upsertCategory(array $resources): void
    {
        $this->client->getCategoryApi()->upsertList($resources);
    }
}
