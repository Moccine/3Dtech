<?php

declare(strict_types=1);

namespace App\Constant;

class Attribute
{
    public const UNIQUE = 'unique';
    public const CODE = 'code';
    public const USEABLE_AS_GRID_FILTER = 'useable_as_grid_filter';
    public const ALLOWED_EXTENSIONS = 'allowed_extensions';
    public const METRIC_FAMILY = 'metric_family';
    public const DEFAULT_METRIC_UNIT = 'default_metric_unit';
    public const REFERENCE_DATA_NAME = 'reference_data_name';
    public const AVAILABLE_LOCALES = 'available_locales';
    public const MAX_CHARACTERS = 'max_characters';
    public const VALIDATION_RULE = 'validation_rule';
    public const VALIDATION_REGEXP = 'validation_regexp';
    public const WYSIWYG_ANABLED = 'wysiwyg_enabled';
    public const NUMBER_MIN = 'number_min';
    public const NUMBER_MAX = 'number_max';
    public const DECIMALS_ALLOWED = 'decimals_allowed';
    public const NEGATIVE_ALLOWED = 'negative_allowed';
    public const DATE_MIN = 'date_min';
    public const DATE_MAX = 'date_max';
    public const MAX_FILE_SIZE = 'max_file_size';
    public const MINIMUM_INPUT_LENGTH = 'minimum_input_length';
    public const SORT_ORDER = 'sort_order';
    public const LOCALIZABLE = 'localizable';
    public const SCOPABLE = 'scopable';
    public const TYPE = 'type';
    public const GROUP = 'group';
    public const LABELS = 'labels';
    public const CATALOG_SIMPLE_SELECT = 'pim_catalog_simpleselect';
    public const CATALOG_MULTI_SELECT = 'pim_catalog_multiselect';
    public const CATALOG_SELECT = [
        self::CATALOG_MULTI_SELECT,
        self::CATALOG_SIMPLE_SELECT,
    ];
}
