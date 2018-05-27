<?php

/*
 * This file is part of the MadForWebs package
 *
 * Copyright (c) 2017 Fernando Sánchez Martínez
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Fernando Sánchez Martínez <fer@madforwebs.com>
 */

namespace MadForWebs\UserBundle\Entity\Repository;

use CoreBundle\Entity\Profile;
use CoreBundle\Entity\User;

/**
 * UserRepository.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return int
     */
    public function count(array $criteria)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT COUNT(p) FROM CoreBundle:User p '
        );

        return $query->getSingleScalarResult();
    }

    /**
     * @param string $profile
     *
     * @return int
     */
    public function countByProfile(string $profile)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT COUNT(p) FROM CoreBundle:User p '.
            ' WHERE p.profile = :profile '
        )
            ->setParameter('profile', $profile);

        return $query->getSingleScalarResult();
    }

    /**
     * @param User $teacher
     *
     * @return User[]
     */
    public function getStudents(User $teacher)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT user FROM CoreBundle:User user '.
            ' WHERE user.profile = :student '
        )
            ->setParameter('student', Profile::STUDENT);

        return $query->getResult();
    }

    public function findByParameters($parameters) {
        /** @var User $user */
        $user = $parameters['user'];
        if ($user){
            return $this->createQueryBuilder('u')
                ->where('u.id = :user')
                ->setParameter('user', $user->getId());
        }
        return null;
    }

    public function findByFilters($filters)
    {
        if (isset($filters['date_start'])) {
            $dateStart = new \DateTime($filters['date_start']);
        }else{
            $dateStart = null;
        }
        if (isset($filters['date_end'])) {
            $dateEnd = new \DateTime($filters['date_end']);
        }else{
            $dateEnd = null;
        }


        if (isset($filters['username'])) {
            $username = $filters['username'];
        }else{
            $username = null;
        }
        $query = $this->createQueryBuilder('user');
        $firstFilter = true;
        if(!is_null($dateStart)){
            if($firstFilter){
                $query->where('user.createdAt >= :dateStart')->setParameter('dateStart', $dateStart);
            }else{
                $query->andWhere('user.createdAt >= :dateStart')->setParameter('dateStart', $dateStart);
            }
            $firstFilter = false;
        }
        if(!is_null($dateEnd)){
            if($firstFilter){
                $query->where('user.createdAt <= :dateEnd')->setParameter('dateEnd', $dateEnd);
            }else{
                $query->andWhere('user.createdAt <= :dateEnd')->setParameter('dateEnd', $dateEnd);
            }
            $firstFilter = false;
        }

        if(!is_null($username)){
            if($firstFilter){
                $query->where('user.username = :username')->setParameter('username', $username);
            }else{
                $query->andWhere('user.username = :username')->setParameter('username', $username);
            }
            $firstFilter = false;
        }

        $query->addOrderBy("user.createdAt","ASC");
        return $query->getQuery()->getResult();
    }
}
