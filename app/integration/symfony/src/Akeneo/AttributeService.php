<?php

declare(strict_types=1);

namespace App\Akeneo;

use App\Constant\Attribute;

class AttributeService extends AkeneoService
{
    /**
     * @return array
     */
    public function setAttributeResource(array $data)
    {
        return [
            Attribute::CODE => $data[Attribute::CODE],
            Attribute::TYPE => $data[Attribute::TYPE],
            Attribute::GROUP => $data[Attribute::GROUP],
            Attribute::LABELS => $data[Attribute::LABELS],
            Attribute::UNIQUE => isset($data[Attribute::UNIQUE]) ? $data[Attribute::UNIQUE] : false,
            Attribute::USEABLE_AS_GRID_FILTER => isset($data[Attribute::USEABLE_AS_GRID_FILTER]) ? $data[Attribute::USEABLE_AS_GRID_FILTER] : true,
            Attribute::ALLOWED_EXTENSIONS => isset($data[Attribute::ALLOWED_EXTENSIONS]) ? $data[Attribute::ALLOWED_EXTENSIONS] : [],
            Attribute::METRIC_FAMILY => isset($data[Attribute::METRIC_FAMILY]) ? $data[Attribute::METRIC_FAMILY] : null,
            Attribute::DEFAULT_METRIC_UNIT => isset($data[Attribute::DEFAULT_METRIC_UNIT]) ? $data[Attribute::DEFAULT_METRIC_UNIT] : null,
            Attribute::REFERENCE_DATA_NAME => isset($data[Attribute::REFERENCE_DATA_NAME]) ? $data[Attribute::REFERENCE_DATA_NAME] : null,
            Attribute::AVAILABLE_LOCALES => isset($data[Attribute::AVAILABLE_LOCALES]) ? $data[Attribute::AVAILABLE_LOCALES] : [],
            Attribute::MAX_CHARACTERS => isset($data[Attribute::MAX_CHARACTERS]) ? $data[Attribute::MAX_CHARACTERS] : null,
            Attribute::VALIDATION_RULE => isset($data[Attribute::VALIDATION_RULE]) ? $data[Attribute::VALIDATION_RULE] : null,
            Attribute::VALIDATION_REGEXP => isset($data[Attribute::VALIDATION_REGEXP]) ? $data[Attribute::VALIDATION_REGEXP] : null,
            Attribute::WYSIWYG_ANABLED => isset($data[Attribute::WYSIWYG_ANABLED]) ? $data[Attribute::WYSIWYG_ANABLED] : null,
            Attribute::NUMBER_MIN => isset($data[Attribute::NUMBER_MIN]) ? $data[Attribute::NUMBER_MIN] : null,
            Attribute::NUMBER_MAX => isset($data[Attribute::NUMBER_MAX]) ? $data[Attribute::NUMBER_MAX] : null,
            Attribute::DECIMALS_ALLOWED => isset($data[Attribute::DECIMALS_ALLOWED]) ? $data[Attribute::DECIMALS_ALLOWED] : null,
            Attribute::NEGATIVE_ALLOWED => isset($data[Attribute::NEGATIVE_ALLOWED]) ? $data[Attribute::NEGATIVE_ALLOWED] : null,
            Attribute::DATE_MIN => isset($data[Attribute::DATE_MIN]) ? $data[Attribute::DATE_MIN] : null,
            Attribute::DATE_MAX => isset($data[Attribute::DATE_MAX]) ? $data[Attribute::DATE_MAX] : null,
            Attribute::MAX_FILE_SIZE => isset($data[Attribute::MAX_FILE_SIZE]) ? $data[Attribute::MAX_FILE_SIZE] : null,
            Attribute::MINIMUM_INPUT_LENGTH => isset($data[Attribute::MINIMUM_INPUT_LENGTH]) ? $data[Attribute::MINIMUM_INPUT_LENGTH] : null,
            Attribute::SORT_ORDER => isset($data[Attribute::SORT_ORDER]) ? $data[Attribute::SORT_ORDER] : 1,
            Attribute::LOCALIZABLE => isset($data[Attribute::LOCALIZABLE]) ? $data[Attribute::LOCALIZABLE] : false,
            Attribute::SCOPABLE => isset($data[Attribute::SCOPABLE]) ? $data[Attribute::SCOPABLE] : false,
        ];
    }

    public function upsertAttributes(array $data)
    {
        $data = $this->setAttributeResource($data);
        $code = $data[Attribute::CODE];
        unset($data[Attribute::CODE]);
        $this->client->getAttributeApi()->upsert($code, $data);
    }

    /**
     * $resource array like this:
     * [
     *     'code'                   => 'release_date',
     *     'type'                   => 'pim_catalog_date',
     *     'group'                  => 'marketing',
     *     'unique'                 => false,
     *     'useable_as_grid_filter' => true,
     *     'allowed_extensions'     => [],
     *     'metric_family'          => null,
     *     'default_metric_unit'    => null,
     *     'reference_data_name'    => null,
     *     'available_locales'      => [],
     *     'max_characters'         => null,
     *     'validation_rule'        => null,
     *     'validation_regexp'      => null,
     *     'wysiwyg_enabled'        => null,
     *     'number_min'             => null,
     *     'number_max'             => null,
     *     'decimals_allowed'       => null,
     *     'negative_allowed'       => null,
     *     'date_min'               => '2017-06-28T08:00:00',
     *     'date_max'               => '2017-08-08T22:00:00',
     *     'max_file_size'          => null,
     *     'minimum_input_length'   => null,
     *     'sort_order'             => 1,
     *     'localizable'            => false,
     *     'scopable'               => false,
     *     'labels'                 => [
     *         'en_US' => 'Sale date',
     *         'fr_FR' => 'Date des soldes'],
     *     ]
     * ].
     */
    public function upsertListAttribute(array $resources): void
    {
        $resources = array_map(function ($resource) { // remplir les valeur par defaut
            return $this->setAttributeResource($resource);
        }, $resources);

        $this->client->getAttributeApi()->upsertList($resources);
    }
}
