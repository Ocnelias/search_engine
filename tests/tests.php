<?php

namespace search_engine;
use PHPUnit\Framework\TestCase;

require_once('index.php');

class AbstractFactoryTest extends TestCase
{
    public function testCanCreateCyrillicList()
    {
        $factory = new CyrillicEngine();
        $search = $factory->createSearchKeywords();

        $this->assertInstanceOf(CyrillicList::class, $search);


     }

    public function testCanCreateEnglishList()
    {
        $factory = new EnglishEngine();
        $search = $factory->createSearchKeywords();

        $this->assertInstanceOf(EnglishList::class, $search);


    }


    public function testCanCreateCiryllicKeywords()
    {
        $factory = new CyrillicEngine();
        $search = $factory->createSearchKeywords();

        $this->assertInternalType('object',  $search);
    }

    public function testCanCreateEnglishKeywords()
    {
        $factory = new EnglishEngine();
        $search = $factory->createSearchKeywords();

        $this->assertInternalType('object',  $search);
    }


}