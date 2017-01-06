<?php

namespace App\Blog;

use App\Blog\Contracts\Tag;
use App\Blog\Exceptions\TagDoesNotExist;
use App\Blog\Exceptions\DoesNotImplementContract;

class TagManager
{

    /**
     * @var string
     */
    private $namespace = '\\App\\Blog\\Tags';

    /**
     * @var string
     */
    private $alias;

    /**
     * @param string $alias
     *
     * @return TagManager
     */
    public static function make($alias)
    {
        return new static($alias);
    }

    /**
     * @param string $alias
     *
     * @return Tag
     */
    public static function get($alias)
    {
        return static::make($alias)->getTag();
    }

    /**
     * @param string $alias
     */
    private function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        $alias = $this->getAlias();
        $alias = strtolower($alias);
        $alias = str_replace('-', ' ', $alias);
        $alias = ucwords($alias);
        $alias = str_replace(' ', '', $alias);
        return $alias;
    }

    /**
     * @throws TagDoesNotExist
     * @throws DoesNotImplementContract
     *
     * @return Tag
     */
    public function getTag()
    {

        $className = sprintf(
            '%s\\%s',
            $this->getNamespace(),
            $this->getClassName()
        );

        if (!class_exists($className)) {
            throw new TagDoesNotExist(sprintf(
                'Unable to load the tag "%s" with the class "%s".',
                $this->getAlias(),
                $className
            ));
        }

        $tag = new $className;

        if (!$tag instanceof Tag) {
            throw new DoesNotImplementContract(sprintf(
                'The loaded tag "%s" does not implement the "%s" contract.',
                $this->getAlias(),
                Tag::class
            ));
        }

        return new $tag;

    }

    /**
     * @param string $namespace
     *
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

}
