<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Entity\Agency;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Elastica\Index;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\GeoDistance;
use Elastica\Query\MatchAll;
use Elastica\Query\Nested;
use FOS\ElasticaBundle\Finder\FinderInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MachineSearch extends BaseEsService
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
    private $machineIndex;

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
        $this->index = $this->container->get('fos_elastica.index.machine');
        $this->machineIndex = $this->container->get('fos_elastica.index.machine.machine');
        $this->finder = $this->container->get('fos_elastica.finder.machine.machine');
    }

    /**
     * @param int $limit
     *
     * @return array|string
     */
    public function getMachinesByGeoLoc(Agency $agency, int $distance = 1, $limit = self::SEARCH_LIMIT)
    {
        try {
            $query = new Query();
            $boolQuery = new BoolQuery();
            $geoQuery = new GeoDistance('agency.agencyGeoPoint', [
                'lat' => (float) $agency->getAddress()->getLatitude(),
                'lon' => (float) $agency->getAddress()->getLongitude(),
            ], sprintf('%dkm', $distance));
            $boolQuery->addMust(new MatchAll());
            $nested = new Nested();
            $nested->setPath('agency');
            $boolQuery->addFilter($geoQuery);
            $nested->setQuery($boolQuery);
            $query->setQuery($nested);

            return $this->finder->find($query, $limit);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getMachineList(int $limit = self::SEARCH_LIMIT): array
    {
        try {
            $query = new Query(new MatchAll());

            return $this->finder->find($query, $limit);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
