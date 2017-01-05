<?php

namespace Test\App\Blog;

use App\Blog\TagManager;
use Test\App\AbstractTestCase;

class TagManagerTest extends AbstractTestCase
{

    /**
     * Create an instance of the tag manager setting the testing namespace.
     *
     * @param string $alias
     * @return TagManager
     */
    private function getTestableTagManager($alias)
    {
        return TagManager::make($alias)->setNamespace('\\Test\\App\\Blog\\Fixtures');
    }

    public function aliasToClassNameProvider()
    {
        return [
            ['tag-name', 'TagName'],
            ['this-is-the-tag', 'ThisIsTheTag'],
            ['What-EvEn-iS-ThIs', 'WhatEvenIsThis'],
            ['Strange---Class-Name', 'StrangeClassName']
        ];
    }

    /**
     * @test
     * @dataProvider aliasToClassNameProvider
     */
    public function itParsesTheAliasToClassNamesCorrectly($alias, $className)
    {
        $this->assertEquals(
            TagManager::make($alias)->getClassName(),
            $className
        );
    }

    /**
     * @test
     * @dataProvider aliasToClassNameProvider
     */
    public function itStoresTheAliasCorrectly($alias)
    {
        $this->assertEquals(
            TagManager::make($alias)->getAlias(),
            $alias
        );
    }

    /**
     * @test
     * @expectedException \App\Blog\Exceptions\TagDoesNotExist
     */
    public function itHandlesNoneExistinTags()
    {
        TagManager::get('does-not-exist');
    }

    /**
     * @test
     * @expectedException \App\Blog\Exceptions\DoesNotImplementContract
     */
    public function itHandlesTagsWithTheWrongImplementation()
    {
        $this->getTestableTagManager('wrong-implementation')->getTag();
    }

    /**
     * @test
     */
    public function itLoadsACustomTagCorrectly()
    {
        $this->assertEquals(
            $this->getTestableTagManager('my-tag')->getTag()->getName(),
            'My Tag'
        );
    }

}
