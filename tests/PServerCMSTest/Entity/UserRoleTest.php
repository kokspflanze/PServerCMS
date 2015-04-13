<?php


namespace PServerCMSTest\Entity;


use PServerCMS\Entity\User;
use PServerCMS\Entity\UserRole;

class UserRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $entity = new UserRole();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $entity->getUser());
        $this->assertInstanceOf('PServerCMS\Entity\UserRoleInterface', $entity);
        $this->assertInstanceOf('SmallUser\Entity\UserRoleInterface', $entity);
        $this->assertInstanceOf('BjyAuthorize\Acl\HierarchicalRoleInterface', $entity);
        $this->assertEmpty($entity->getUser());
    }

    public function testId()
    {
        $entity = new UserRole();
        $id = rand(0,99999);
        $result = $entity->setId($id);

        $this->assertEquals($entity, $result);
        $this->assertEquals($id, $result->getId());
    }

    public function testRoleId()
    {
        $entity = new UserRole();
        $id = 'foobar';
        $result = $entity->setRoleId($id);

        $this->assertEquals($entity, $result);
        $this->assertEquals($id, $result->getRoleId());
    }

    public function testIsDefault()
    {
        $entity = new UserRole();
        $default = true;
        $result = $entity->setIsDefault($default);

        $this->assertEquals($entity, $result);
        $this->assertEquals($default, $result->getIsDefault());
    }

    public function testParent()
    {
        $entity = new UserRole();
        $default = 'foobar';
        $result = $entity->setParent($default);

        $this->assertEquals($entity, $result);
        $this->assertEquals($default, $result->getParent());
    }

    public function testAddUser()
    {
        $entity = new UserRole();

        $entityUser = new User();
        $result = $entity->addUser($entityUser);

        $this->assertEquals($entity, $result);
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $result->getUser());
        $this->assertNotEmpty($result->getUser()[0]);
        $this->assertEquals($entityUser, $result->getUser()[0]);
    }

    public function testRemoveUser()
    {
        $entity = new UserRole();

        $entityUser = new User();
        $entity->addUser($entityUser);
        $entity->removeUser($entityUser);
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $entity->getUser());
        $this->assertEmpty($entity->getUser());

    }
}
