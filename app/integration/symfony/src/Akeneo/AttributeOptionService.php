<?php

declare(strict_types=1);

namespace App\Akeneo;

class AttributeOptionService extends AkeneoService
{
    /**
     *  array like this:
     * [
     *     'code'       => 'black',
     *     'attribute'  => 'a_simple_select',
     *     'sort_order' => 2,
     *     'labels'     => [
     *         'en_US' => 'Black',
     *         'fr_FR' => 'Noir',
     *     ]
     * ].
     */
    public function upsertAttributeOption(string $attribute, array $resource): void
    {
        $this->client->getAttributeOptionApi()->upsertList($attribute, $resource);
    }
}
