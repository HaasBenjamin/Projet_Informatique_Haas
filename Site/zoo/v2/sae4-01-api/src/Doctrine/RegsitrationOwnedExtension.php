<?php

declare(strict_types=1);

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Registration;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class RegsitrationOwnedExtension implements QueryCollectionExtensionInterface
{
    public function __construct(private Security $security)
    {
    }

    public function addWhere(QueryBuilder $queryBuilder, string $ressourceClass): void
    {
        if (Registration::class !== $ressourceClass) {
            return;
        }
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $user = $this->security->getUser();
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles());
        if (!$isAdmin) {
            $queryBuilder->andWhere(sprintf('%s.user = :owner', $rootAlias))
                ->setParameter('owner', $user);
        }
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }
}
