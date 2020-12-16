<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use Doctrine\ORM\EntityManager;
use Exception;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class BaseEsService
{
    const ENV_DEV = 'dev';
    const MINIMUM_SHOULD_MATCH = 1;
    const SEARCH_LIMIT = 50;

    protected string $elasticHost;

    protected string $elasticPort;

    protected TranslatorInterface $translator;

    protected EntityManager $em;

    protected Router $router;

    protected string $entityName;

    protected Logger $logger;

    private string $env;

    private string $elasticIndex;

    /**
     * ElasticaService constructor.
     */
    public function __construct(
        TranslatorInterface $translator,
        EntityManager $em,
        Router $router,
        Logger $logger
    ) {
        $this->translator = $translator;
        $this->em = $em;
        $this->router = $router;
        $this->logger = $logger;
        $this->elasticHost = $_ENV['ELASTICSEARCH_HOST'];
        $this->elasticPort = $_ENV['ELASTICSEARCH_PORT'];
        $this->elasticIndex = $_ENV['ELASTICSEARCH_NAME'];
        $this->env = $_ENV['APP_ENV'];
    }

    private function getSearchUrl(): string
    {
        return sprintf('http://%s:%s/%s/%s/_search', $this->elasticHost, $this->elasticPort, $this->elasticIndex, $this->entityName);
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/6.8/docs-update.html
     */
    private function getUpdateApiUrl(int $id): string
    {
        return sprintf('http://%s:%s/%s/%s/%d/_update', $this->elasticHost, $this->elasticPort, $this->elasticIndex, $this->entityName, $id);
    }

    /**
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/6.8/docs-update-by-query.html
     */
    private function getUpdateByQueryApiUrl(): string
    {
        return sprintf('http://%s:%s/%s/%s/_update_by_query', $this->elasticHost, $this->elasticPort, $this->elasticIndex, $this->entityName);
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    private function getRawResponse(string $url, array $query)
    {
        $queryJson = json_encode($query);

        if (self::ENV_DEV === $this->env) {
            $this->logger->debug($queryJson, ['url' => $url]);
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $queryJson);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (Response::HTTP_OK !== $status) {
            $message = sprintf('Error: call to URL %s failed with status %s, response: [ %s ] %s (curl_error: %s',
                $url, $status, $response, curl_error($curl), curl_error($curl));
            throw new Exception($message);
        }
        curl_close($curl);
        $responseAsArray = json_decode($response, true);
        if (null === $responseAsArray) {
            throw new Exception($response);
        }

        return $responseAsArray;
    }

    /**
     * @throws Exception
     */
    protected function getSearchResult(array $query): array
    {
        $response = $this->getRawResponse($this->getSearchUrl(), $query);
        $result = [
            'total' => null,
            'data' => [],
        ];
        if (isset($response['timed_out'])
            && false === $response['timed_out']
            && isset($response['hits'])) {
            $result['total'] = $response['hits']['total'];
            foreach ($response['hits']['hits'] as $data) {
                if (isset($data['_source'])) {
                    $result['data'][] = $data['_source'];
                }
            }
        }

        return $result;
    }

    private function getUpdateResult(string $url, array $query): bool
    {
        $result = false;
        try {
            $this->getRawResponse($url, $query);
            $result = true;
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(),
                [
                    'url' => $url,
                    'query' => $query,
                ]
            );
        }

        return $result;
    }

    /**
     * @param string $condition must|must_not|should
     */
    protected function generateBoolQuery(array $query, string $condition): array
    {
        return ['bool' => [$condition => $query]];
    }

    protected function generateMustQuery(array $query): array
    {
        return $this->generateBoolQuery($query, 'must');
    }

    protected function generateMustNotQuery(array $query): array
    {
        return $this->generateBoolQuery($query, 'must_not');
    }

    /**
     * @return array
     */
    protected function generateShouldQuery(array $query)
    {
        return $this->generateBoolQuery($query, 'should');
    }

    /**
     * @param mixed $value
     */
    protected function generateMatchQuery(string $key, $value): array
    {
        return ['match' => [$key => $value]];
    }

    protected function generateIdsQuery(array $value = []): array
    {
        return ['ids' => ['values' => $value]];
    }

    protected function generateWildCardQuery(string $fieldName, string $searchText, bool $onlyBeginWith = true): array
    {
        $searchText = explode(' ', strtolower((trim($searchText)))); // TODO remove accent
        $startWithText = $onlyBeginWith ? '' : '*';

        $wildcards = [];
        foreach ($searchText as $text) {
            $wildcards[] = [
                'wildcard' => [
                    $fieldName => $startWithText.$text.'*',
                ],
            ];
        }

        return $wildcards;
    }

    /**
     * @return array
     */
    protected function generateMultiMatchPhrasePrefixQuery(array $fieldNames, string $searchText)
    {
        return $matchPhrasePrefix = [
            'multi_match' => [
                'query' => trim($searchText),
                'type' => 'phrase_prefix',
                'fields' => $fieldNames,
                'operator' => 'or',
                'analyzer' => 'ignore_accent',
                'minimum_should_match' => self::MINIMUM_SHOULD_MATCH,
            ],
        ];
    }

    protected function generateNestedQuery(string $path, array $query): array
    {
        return [
            'nested' => [
                'path' => $path,
                'query' => $query,
            ],
        ];
    }

    /**
     * Sort fields with type like `integer`, `boolean`, `date`, etc (sortable by default).
     */
    public function generateSortFieldQuery(string $orderDir, string $orderBy): array
    {
        return [$orderBy => $orderDir];
    }

    /**
     * Sort text field with `fields: { raw: { type: keyword, index: true } }` setting.
     */
    public function generateSortRawFieldQuery(string $orderDir, string $orderBy): array
    {
        return [sprintf('%s.raw', $orderBy) => $orderDir];
    }

    /**
     * Sort text field with `fields: { lowercase: { type: keyword, normalizer: case_insensitive } }` setting.
     */
    protected function generateSortCaseInsensitiveFieldQuery(string $orderDir, string $orderBy): array
    {
        return [sprintf('%s.lowercase', $orderBy) => $orderDir];
    }

    /**
     * Sort nested text field with `fields: { raw: { type: keyword, index: true } }` setting
     * Reference: https://www.elastic.co/guide/en/elasticsearch/reference/6.8/multi-fields.html.
     *
     * @return array
     */
    public function generateSortNestedRawFieldQuery(string $orderDir, string $fieldName, string $nestedPath)
    {
        return $this->generateSortNestedFieldQuery($orderDir, sprintf('%s.raw', $fieldName), $nestedPath);
    }

    /**
     * Sort nested text field with `fields: { lowercase: { type: keyword, normalizer: case_insensitive } }` setting.
     *
     * @return array
     */
    protected function generateSortNestedCaseInsensitiveFieldQuery(string $orderDir, string $fieldName, string $nestedPath)
    {
        return $this->generateSortNestedFieldQuery($orderDir, sprintf('%s.lowercase', $fieldName), $nestedPath);
    }

    /**
     * Sort nested field with type like `integer`, `boolean`, `date`, etc (sortable by default).
     *
     * @return array
     */
    protected function generateSortNestedFieldQuery(string $orderDir, string $fieldName, string $nestedPath)
    {
        return [
            $fieldName => [
                'order' => $orderDir,
                'nested_path' => $nestedPath,
            ],
        ];
    }

    /**
     * @param DateTime|null $from
     * @param DateTime|null $to
     */
    protected function generateDateRangeQuery(string $fieldName, DateTime $from, DateTime $to): array
    {
        $filterDate = ['format' => 'dd/MM/yyyy HH:mm:ss'];
        if (null !== $from) {
            $filterDate['gte'] = $from->format('d/m/Y').' 00:00:00';
        }
        if (null !== $to) {
            $filterDate['lte'] = $to->format('d/m/Y').' 00:00:00';
        }

        return [
            'range' => [
                $fieldName => $filterDate,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function generateTermsQuery(string $fieldName, array $values = [])
    {
        return [
            'terms' => [
                $fieldName => $values,
            ],
        ];
    }

    /**
     * @param $fieldName
     */
    protected function generateMultiMatchQuery($fieldName, array $values = []): array
    {
        $should = [];
        foreach ($values as $key => $value) {
            $should[$key]['match'] = [$fieldName => $value];
        }

        return [
            'bool' => [
                'should' => $should,
            ],
        ];
    }
}
