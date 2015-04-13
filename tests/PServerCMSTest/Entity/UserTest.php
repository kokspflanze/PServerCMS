<?php


namespace PServerCMSTest\Entity;

use PServerCMS\Entity\User;
use PServerCMS\Entity\UserRole;
use Zend\Crypt\Password\Bcrypt;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $entity = new User();

        $this->assertInstanceOf('DateTime', $entity->getCreated());
        $this->assertInstanceOf('PServerCMS\Entity\UserInterface', $entity);
        $this->assertInstanceOf('SmallUser\Entity\UserInterface', $entity);
        $this->assertInstanceOf('BjyAuthorize\Provider\Role\ProviderInterface', $entity);
    }

    public function testUserId()
    {
        $entity = new User();
        $usrId = rand(0,99999);
        $result = $entity->setId($usrId);

        $this->assertEquals($entity, $result);
        $this->assertEquals($usrId, $result->getId());
    }

    public function testUsername()
    {
        $entity = new User();
        $username = rand(0,99999);
        $result = $entity->setUsername($username);

        $this->assertEquals($entity, $result);
        $this->assertEquals($username, $result->getUsername());
    }

    public function testBackendId()
    {
        $entity = new User();
        $backendId = rand(0,99999);
        $result = $entity->setBackendId($backendId);

        $this->assertEquals($entity, $result);
        $this->assertEquals($backendId, $result->getBackendId());
    }

    public function testPassword()
    {
        $entity = new User();
        $password = rand(0,99999);
        $result = $entity->setPassword($password);

        $this->assertEquals($entity, $result);
        $this->assertEquals($password, $result->getPassword());
    }

    public function testEmail()
    {
        $entity = new User();
        $email = 'foo@bar.baz';
        $result = $entity->setEmail($email);

        $this->assertEquals($entity, $result);
        $this->assertEquals($email, $result->getEmail());
    }

    public function testCreated()
    {
        $entity = new User();
        $dateTime = new \DateTime();
        $result = $entity->setCreated($dateTime);

        $this->assertEquals($entity, $result);
        $this->assertEquals($dateTime, $result->getCreated());
    }

    public function testCreatedIp()
    {
        $entity = new User();
        $createdIp = '127.0.0.45';
        $result = $entity->setCreateIp($createdIp);

        $this->assertEquals($entity, $result);
        $this->assertEquals($createdIp, $result->getCreateIp());
    }

    public function testAddUserRole()
    {
        $entity = new User();
        $entityRole = new UserRole();
        $result = $entity->addUserRole($entityRole);
        $this->assertEquals($entity, $result);

        $result = $entity->getUserRole();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $result);
        $this->assertEquals($entityRole, $result[0]);
    }

    public function testRemoveUserRole()
    {
        $entity = new User();
        $entityRole = new UserRole();
        $entity->addUserRole($entityRole);

        $entity->removeUserRole($entityRole);

        $result = $entity->getUserRole();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $result);
        $this->assertEmpty($result);
    }

    public function testGetRoles()
    {
        $entity = new User();
        $result = $entity->getRoles();
        $this->assertEmpty($result);

        $entityRole = new UserRole();
        $entity->addUserRole($entityRole);
        $result = $entity->getRoles();
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf('Zend\Permissions\Acl\Role\RoleInterface', $result[0]);
    }

    public function testHashPassword()
    {
        $this->markTestIncomplete('missing mock servicemanager');

        $entity = new User();
        $password = 'foobar';
        $bCrypt = new Bcrypt();

        $entity->setPassword($bCrypt->create( $password ));
        $result = User::hashPassword($entity, $password);

        $this->assertTrue($result);
    }


}
