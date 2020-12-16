<?php

declare(strict_types=1);

namespace App\Constant;

class AttributeType
{
    const CATALOG_IDENTIFIER = 'pim_catalog_identifier'; // It is the unique product’s identifier. The catalog can contain only one.
    const CATALOG_TEXT = 'pim_catalog_text'; //	Text
    const CATALOG_TEXTAREA = 'pim_catalog_textarea';    //Long text
    const CATALOG_BOOLEAN = 'pim_catalog_boolean';    //Yes/No
    const CATALOG_NUMBER = 'pim_catalog_number'; //	Number (integer and float)
    const CATALOG_SIMPLE_SELECT = 'pim_catalog_simpleselect';    //Simple choice list
    const CATALOG_MULTI_SELECT = 'pim_catalog_multiselect'; //	Multiple choice list
    const CATALOG_DATE = 'pim_catalog_date'; //	Date
    const CATALOG_METRIC = 'pim_catalog_metric'; //	Metric. It links a value and a unit like a weight.
    const CATALOG_PRICE_COLLECT = 'pim_catalog_price_collection'; //Collection of prices. Each price contains a value and a currency
    const CATALOG_IMAGE = 'pim_catalog_image'; //	Image
    const CATALOG_FILE = 'pim_catalog_file'; //	File

    public const TYPES = [
        self::CATALOG_IDENTIFIER,
        self::CATALOG_TEXT,
        self::CATALOG_TEXTAREA,
        self::CATALOG_BOOLEAN,
        self::CATALOG_NUMBER,
        self::CATALOG_SIMPLE_SELECT,
        self::CATALOG_MULTI_SELECT,
        self::CATALOG_DATE,
        self::CATALOG_METRIC,
        self::CATALOG_PRICE_COLLECT,
        self::CATALOG_IMAGE,
        self::CATALOG_FILE,
    ];
}
