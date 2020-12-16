<?php

declare(strict_types=1);

namespace App\Akeneo;

use App\Constant\AttributeGroup;

class AttributeGroupService extends AkeneoService
{
    public function setAttributeGroupDatas(array $resources)
    {
        return [
            AttributeGroup::CODE => $resources['code'],
            AttributeGroup::ATTRIBUTES => isset($resources['attributes']) ? $resources['attributes'] : [],
            AttributeGroup::LABELS => isset($resources['labels']) ? $resources['labels'] : [],
        ];
    }

    public function upsertAttributeGroup(array $resources)
    {
        $this->client->getAttributeGroupApi()->upsertList($resources);
    }
}
