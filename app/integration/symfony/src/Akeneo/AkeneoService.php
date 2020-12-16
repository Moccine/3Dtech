<?php

declare(strict_types=1);

namespace App\Akeneo;

use Akeneo\Pim\ApiClient;
use Akeneo\Pim\ApiClient\Pagination\ResourceCursorInterface;
use Akeneo\Pim\ApiClient\Search\SearchBuilder;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientBuilder;
use App\Constant\Attribute as AttributeConst;
use App\Constant\Category as CategoryConst;
use App\Constant\Product;
use App\Entity\Attribute;
use App\Entity\Category;
use App\Entity\Family;
use App\Entity\Machine;
use App\Entity\MachineAttribute;
use App\Manager\AttributeManager;
use App\Manager\CategoryManager;
use App\Manager\FamilyManager;
use App\Manager\MachineAttributeManager;
use App\Manager\MachineManager;
use Doctrine\ORM\EntityManagerInterface;

class AkeneoService
{
    public ApiClient\AkeneoPimClientInterface $client;
    public SearchBuilder $searchBuilder;
    public $clientId;
    public $secret;
    public $password;
    public $baseUrl;
    private $username;
    private EntityManagerInterface $em;
    private CategoryManager $categoryManager;
    private FamilyManager $familyManager;
    private MachineManager $machineManager;
    private AttributeManager $attributeManager;
    private MachineAttributeManager $machineAttributeManager;

    /**
     * AkeneoService constructor.
     */
    public function __construct(EntityManagerInterface $em, CategoryManager $categoryManager, FamilyManager $familyManager, MachineManager $machineManager, AttributeManager $attributeManager, MachineAttributeManager $machineAttributeManager)
    {
        try {
            $this->clientId = $_ENV['AKENEO_PIM_ID_CLIENT'];
            $this->secret = $_ENV['AKENEO_PIM_SERCRET'];
            $this->password = $_ENV['AKENEO_PIM_PASSWORD'];
            $this->username = $_ENV['AKENEO_PIM_USERNAME'];
            $this->baseUrl = $_ENV['AKENEO_PIM_BASE_URL'];
            $this->em = $em;
            $this->categoryManager = $categoryManager;
            $this->familyManager = $familyManager;
            $this->machineManager = $machineManager;
            $this->attributeManager = $attributeManager;
            $this->machineAttributeManager = $machineAttributeManager;
            $clientBuilder = new AkeneoPimEnterpriseClientBuilder($this->baseUrl);
            $this->client = $clientBuilder->buildAuthenticatedByPassword(
                $this->clientId, $this->secret, $this->username, $this->password);
            $this->searchBuilder = new SearchBuilder();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getCatalog(): ResourceCursorInterface
    {
        return $this->client->getProductApi()->all();
    }

    public function getCatalogFamilies()
    {
        return $this->client->getFamilyApi()->all();
    }

    public function getCatalogCategories()
    {
        return $this->client->getCategoryApi()->all();
    }

    public function importCategoriesAndFamilies(): void
    {
        $pimCategories = $this->getCatalogCategories();
        $familyRepository = $this->em->getRepository(Family::class);
        $CategoryRepository = $this->em->getRepository(Category::class);

        foreach ($pimCategories as $pimCategory) {
            if ($pimCategory) {
                $code = $pimCategory[CategoryConst::CODE];
                $parentCode = $pimCategory[CategoryConst::PARENT];
                $labels = $pimCategory[CategoryConst::LABELS];

                $categoryEntity = $CategoryRepository->findOneBy([
                    CategoryConst::CODE => trim($code),
                ]);

                if (!$categoryEntity instanceof Category) {
                    $label = isset($labels[Product::DEFAULT_LABEL]) ? $labels[Product::DEFAULT_LABEL] : null;
                    $categoryEntity = $this->categoryManager->create($code, $label);
                }
                if (null !== $parentCode) {
                    $family = $familyRepository->findOneBy([
                        CategoryConst::CODE => $parentCode,
                    ]);
                    if (!$family instanceof Family) {
                        $family = $this->familyManager->create($parentCode, null);
                    }
                    $family->addCategory($categoryEntity);
                }
                $this->em->flush();
            }
        }
    }

    public function importProductAndAttributes(): void
    {
        $PimProducts = $this->getCatalog();
        $machineRepository = $this->em->getRepository(Machine::class);
        foreach ($PimProducts as $PimProduct) {
            $code = $PimProduct[Product::IDENTIFIER];
            $categoriesCodes = $PimProduct[Product::CATEGORIES];
            $values = $PimProduct[Product::VALUES];
            $CategoryRepository = $this->em->getRepository(Category::class);

            if ($PimProducts) {
                $machine = $machineRepository->findOneBy([
                    Product::CODE => $code,
                ]);
                if (!$machine instanceof Machine) {
                    $machine = $this->machineManager->create($code);
                }
                foreach ($categoriesCodes as $code) {
                    $category = $CategoryRepository->findOneBy([
                        CategoryConst::CODE => trim($code),
                    ]);
                    if (!$category instanceof Category) {
                        throw new \Exception('category not found');
                    }

                    $machine->setCategory($category);
                }

                $attributeRepository = $this->em->getRepository(Attribute::class);
                $machineAttributeRepository = $this->em->getRepository(MachineAttribute::class);
                foreach ($values as $attributeCode => $data) {
                    $attributePim = $this->client->getAttributeApi()->get($attributeCode);
                    $attribute = $attributeRepository->findOneBy([
                        AttributeConst::CODE => $attributeCode,
                    ]);
                    if (!$attribute instanceof Attribute) {
                        $attribute = $this->attributeManager->create($attributeCode, $attributePim[AttributeConst::LABELS]);
                    }
                    $machineAttribute = $machineAttributeRepository->findOneBy([
                        Product::MACHINE => $machine,
                        Product::ATTRIBUTE => $attribute,
                    ]);
                    if (!$machineAttribute instanceof MachineAttribute) {
                        if (\in_array($attributePim[AttributeConst::TYPE], AttributeConst::CATALOG_SELECT)) { // attribute type select
                            $selectData = $data[0]['data'];
                            if (\is_array($selectData)) {
                                $option = $this->client->getAttributeOptionApi()->get($attributeCode, $selectData[0]);
                            } else {
                                $option = $this->client->getAttributeOptionApi()->get($attributeCode, $selectData);
                            }
                            $attributeValue = $option[AttributeConst::LABELS];
                        } else {
                            $attributeValue = $data[0];
                        }
                        $machineAttribute = $this->machineAttributeManager->create($attribute, $attributeValue);
                        $machine->addMachineAttribute($machineAttribute);
                    }
                }
                $this->em->flush();
            }
        }
    }
}
