<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ContactTest
 * @package App\Tests\Entity
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContactTest extends KernelTestCase
{
    use EntityTestCaseTrait;
    use FixturesTrait;

    public function getEntity()
    {
        return (new Contact())
            ->setNumber('+243997020810')
            ->setLang('Français');
    }

    public function testValidEntity(): void
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/contact.yaml']);
        $this->assertHasError($this->getEntity(), 0);
    }

    public function testInvalidNonUniqueEntity(): void
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/contact.yaml']);
        $this->assertHasError($this->getEntity()->setNumber("+243892530482"), 1);
    }

    public function testInvalidBlankNumberEntity(): void
    {
        $this->assertHasError($this->getEntity()->setNumber(''), 2);
    }

    public function testInvalidLengthNumberEntity(): void
    {
        $this->assertHasError($this->getEntity()->setNumber('100'), 1);
        $this->assertHasError($this->getEntity()->setNumber('11111111111111'), 1);
    }

    public function testValidLangEntity(): void
    {
        $langages = ["Français", "Lingala", "Swahili", "Kikongo", "Tshiluba"];
        foreach ($langages as $lang) {
            $this->assertHasError($this->getEntity()->setLang($lang), 0);
        }
    }

    public function testInvalidBlankLangEntity(): void
    {
        $this->assertHasError($this->getEntity()->setLang(''), 2);
    }

    public function testInvalidUnSupportedLangEntity(): void
    {
        $this->assertHasError($this->getEntity()->setLang('Espagnol'), 1);
    }
}
