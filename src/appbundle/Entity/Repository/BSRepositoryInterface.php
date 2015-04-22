<?php
namespace AppBundle\Entity\Repository;

interface BSRepositoryInterface
{
    public function newInstance();
    public function findAll($orderBy = null, $direction = 'ASC');
    public function findById($id);
    public function findByName($text, $orderBy = null, $direction = 'ASC');
}
