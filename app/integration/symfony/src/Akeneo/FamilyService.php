<?php

declare(strict_types=1);

namespace App\Akeneo;

class FamilyService extends AkeneoService
{
    /*
     *  array like this:
     * [
     *     'code'                   => 'caps',
     *     'attributes'             => ['sku', 'name', 'description', 'price', 'color'],
     *     'attribute_as_label'     => 'name',
     *     'attribute_as_image'     => 'picture',
     *     'attribute_requirements' => [
     *         'ecommerce' => ['sku', 'name', 'description', 'price', 'color'],
     *         'tablet'    => ['sku', 'name', 'description', 'price'],
     *     ],
     *     'labels'                 => [
     *         'en_US' => 'Caps',
     *         'fr_FR' => 'Casquettes',
     *     ]
     * ]
     */
    public function upsertFamily(array $resources): void
    {
        $this->client->getFamilyApi()->upsertList($resources);
    }
}
