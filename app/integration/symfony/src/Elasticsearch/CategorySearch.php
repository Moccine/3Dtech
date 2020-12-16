<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Elastica\Index;
use Elastica\Query;
use FOS\ElasticaBundle\Finder\FinderInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CategorySearch extends BaseEsService
{
    /**
     * @var Index
     */
    protected $index;

    /**
     * @var EntityManager|EntityManagerInterface
     */
    protected EntityManager $em;

    /**
     * @var Logger|LoggerInterface
     */
    protected Logger $logger;

    /**
     * @var Index
     */
    private $categoryIndex;

    /**
     * @var FinderInterface|PaginatedFinderInterface
     */
    private $finder;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SearchService constructor.
     */
    public function __construct(
     ContainerInterface $container
    ) {
        $this->container = $container;
        $this->index = $this->container->get('fos_elastica.index.category');
        $this->categoryIndex = $this->container->get('fos_elastica.index.category.category');
        $this->finder = $this->container->get('fos_elastica.finder.category.category');
    }

    /**
     * @return array|string
     */
    public function getCategories(array $ids, int $limit = self::SEARCH_LIMIT)
    {
        try {
            $boolQuery = new Query\Ids($ids);

            return $this->finder->find($boolQuery, $limit);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
