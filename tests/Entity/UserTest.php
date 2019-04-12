<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = new User();
    }

    public function testFullname()
    {
        $fullname = 'Zora Steuber';
        $this->user->setFullname($fullname);

        $this->assertInternalType('string', $this->user->getFullname());
        $this->assertGreaterThanOrEqual(2, strlen($this->user->getFullname()));
        $this->assertLessThanOrEqual(64, strlen($this->user->getFullname()));
        $this->assertEquals($fullname, $this->user->getFullname());
    }

    public function testUsername()
    {
        $username = 'zetta86';
        $this->user->setUsername($username);

        $this->assertInternalType('string', $this->user->getUsername());
        $this->assertGreaterThanOrEqual(2, strlen($this->user->getUsername()));
        $this->assertLessThanOrEqual(64, strlen($this->user->getUsername()));
        $this->assertEquals($username, $this->user->getUsername());
    }

    public function testEmail()
    {
        $email = 'emoen@yahoo.com';
        $this->user->setEmail($email);

        $this->assertRegExp('/^.+\@\S+\.\S+$/', $this->user->getEmail());
        $this->assertLessThanOrEqual(255, strlen($this->user->getEmail()));
        $this->assertEquals($email, $this->user->getEmail());
    }

    protected function tearDown()
    {
        $this->user = null;
    }
}
