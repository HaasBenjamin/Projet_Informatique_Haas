<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Bookmark;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class BookmarkIsPublicOrOwnedExtension implements QueryCollectionExtensionInterface
{
    private readonly \Transliterator $transliterator;

    public function __construct(
        private Security $security,
    ) {
        $this->transliterator = \Transliterator::create('Any-Latin; Latin-ASCII');
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function normalizeName(string $string): string
    {
        return preg_replace('/[^a-z]/', '-', $this->transliterator->transliterate(mb_strtolower($string)));
    }

    private function SafeParams(QueryBuilder $queryBuilder): void
    {
        $params = $queryBuilder->getParameters();
        foreach ($params as $param) {
            if ('name' == $param['name']) {
                $param['value'] = $this->normalizeName($param['value']);
            }
            if ('description' == $param['name']) {
                $param['value'] = $this->normalizeName($param['value']);
            }
        }
    }

    public function applyToGet(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToPatch(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
        $this->SafeParams($queryBuilder);
    }

    public function applyToPost(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->SafeParams($queryBuilder);
    }

    public function applyToDelete(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere($queryBuilder, string $resourceClass): void
    {
        if (Bookmark::class == $resourceClass) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->join(sprintf('%s.owner', $rootAlias), 'own');
            $queryBuilder->andWhere(sprintf('(%s.isPublic = TRUE) OR (own.id = :ownBook)', $rootAlias));
            $queryBuilder->setParameter('ownBook', $this->security?->getUser()?->getId()) ?? -1;
        }
    }
}
