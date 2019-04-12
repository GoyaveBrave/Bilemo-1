<?php

namespace App\Tests\Entity;

use App\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    private $phone;

    protected function setUp()
    {
        $this->phone = new Phone();
    }

    public function testName()
    {
        $name = 'Razer Phone 2';
        $this->phone->setName($name);

        $this->assertInternalType('string', $this->phone->getName());
        $this->assertNotEmpty($name, $this->phone->getName());
        $this->assertLessThanOrEqual(64, strlen($this->phone->getName()));
        $this->assertEquals($name, $this->phone->getName());
    }

    public function testPrice()
    {
        $price = '$499.99';
        $this->phone->setPrice($price);

        $this->assertRegExp('/^(\$?([0-9]*\.?\d{2}?)$)/', $this->phone->getPrice());
        $this->assertNotEmpty($price, $this->phone->getPrice());
        $this->assertLessThanOrEqual(8, strlen($this->phone->getPrice()));
        $this->assertEquals($price, $this->phone->getPrice());
    }

    public function testDescription()
    {
        $description = "We set the standard in mobile gaming with the Razer phone, but didn't stop there. ";
        $description .= "The RAZER Phone 2 levels up mobile gaming with a brighter 1440P 120Hz ";
        $description .= "display with ultra motion technology which delivers smooth, sharp, and ";
        $description .= "stutter-free visuals combined with an upgraded Snapdragon 845 with vapor chamber cooling. ";
        $description .= "It’s paired with flagship features including wireless charging, ";
        $description .= "water resistance, and Chroma RGB lighting for full customization. ";
        $description .= "The Razer phone 2’s vastly improved Dual cameras ";
        $description .= "let you capture reality in all its glory with an F/1. ";
        $description .= "75 wide lens with oil combined with a Telephoto.";
        $this->phone->setDescription($description);

        $this->assertInternalType('string', $this->phone->getDescription());
        $this->assertNotEmpty($description, $this->phone->getDescription());
        $this->assertEquals($description, $this->phone->getDescription());
    }

    protected function tearDown()
    {
        $this->phone = null;
    }
}
