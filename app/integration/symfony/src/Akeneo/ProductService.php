<?php

declare(strict_types=1);

namespace App\Akeneo;

use App\Constant\Product;

class ProductService extends AkeneoService
{
    /*
   * One array $resource like this:
   * [
   *     'identifier' => 'top',
   *     'enabled' => true,
   *     'family' => 'tshirt',
   *     'categories' => ['summer_collection'],
   *     'groups' => [],
   *     'parent' => null,
   *     'values' => [
   *         'name' => [
   *              [
   *                  'data' => 'Top',
   *                  'locale' => 'en_US',
   *                  'scope' => null
   *              ],
   *              [
   *                  'data' => 'Débardeur',
   *                  'locale' => 'fr_FR',
   *                  'scope' => null
   *              ],
   *         ],
   *     ],
   *     'created' => '2016-06-23T18:24:44+02:00',
   *     'updated' => '2016-06-25T17:56:12+02:00',
   *     'associations' => [
   *         'PACK' => [
   *             'products' => [
   *                 'sunglass'
   *             ],
   *             'groups' => [],
   *             'product_models' => []
   *         ],
   *     ],
   *     'quantified_associations' => [
   *         'PRODUCT_SET' => [
   *             'products' => [
   *                 ['identifier' => 'earings', 'quantity' => 2],
   *             ],
   *             'product_models' => [],
   *         ],
   *     ],
   * ]
   */

    public function upsetListProduct(array $resources): void
    {
        $this->client->getProductApi()->upsertList($resources);
    }

    public function setProductResource(array $resources): array
    {
        return [
            Product::IDENTIFIER => isset($resources[Product::IDENTIFIER]),
            Product::ENABLED => isset($resources[Product::ENABLED]) ? $resources[Product::ENABLED] : false,
            Product::FAMILY => $resources[Product::FAMILY],
            Product::CATEGORIES => $resources[Product::CATEGORIES],
            Product::GROUPS => isset($resources[Product::GROUPS]) ? $resources[Product::GROUPS] : [],
            Product::PARENT => isset($resources[Product::PARENT]) ? $resources[Product::PARENT] : null,
            Product::VALUES => isset($resources[Product::VALUES]) ? $resources[Product::VALUES] : [],
            Product::CREATED => isset($resources[Product::CREATED]) ? $resources[Product::CREATED] : null,
            Product::UPDATED => isset($resources[Product::VALUES]) ? $resources[Product::VALUES] : [],
        ];
    }
}
