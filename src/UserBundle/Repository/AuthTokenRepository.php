<?php

namespace UserBundle\Repository;

/**
 * AuthTokenRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AuthTokenRepository extends \Doctrine\ORM\EntityRepository
{
    /*public function getUserByRole()
    {
        $request = $this->createQueryBuilder('u')
            ->where('u.roles = a:0:{}' )
            ->andWhere('u.roles = a:1:{i:0;s:9:"ROLE_USER";}')
            ->orderBy('u.lastName', 'DESC')
            ->getQuery()
            ->execute()
        ;
        return $request;


    }*/

    /*public function getUserByRole()
    {
        $request = $this->createQueryBuilder('u')
            ->where('u.roles = a:0:{}' )
            ->andWhere('u.roles = a:1:{i:0;s:9:"ROLE_USER";}')
            ->orderBy('u.lastName', 'DESC')
            ->getQuery()
            ->execute()
        ;
        return $request;


    }*/
}
