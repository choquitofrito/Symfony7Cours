<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function livresEntreDeuxPrix(array $filtres){

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT l.titre, l.prix, l.description FROM App\Entity\Livre l WHERE l.prix BETWEEN :prixMin AND :prixMax AND l.titre LIKE UPPER(:titre)');
        $query->setParameter ("prixMin", $filtres['prixMin']);
        $query->setParameter ("prixMax", $filtres['prixMax']);
        $query->setParameter ("titre", "%" . mb_strtoupper($filtres['titre']) . "%");
        $livres = $query->getResult();
        return $livres;
    }

//    /**
//     * @return Livre[] Returns an array of Livre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
