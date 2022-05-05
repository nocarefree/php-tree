<?php

namespace Ncf\PTree;

class Node implements \ArrayAccess{
    private $data = [];
    private $id;
    private $parent;
    private $children;

    public function __construct($item, $id)
    {
        $this->data = $item;   
        $this->id = $id;
        $this->parent = null;
        $this->children = [];
    }

    public function setParent($parent, $link = false)
    {
        $this->parent = $parent;
        if($link){
            $parent->addChildren($this);
        }
    }

    public function addChildren(Node $node, $link = false)
    {
        if(!$this->hasChildren($node->getId())){
            $this->children[$node->getId()] = $node;
        }
        if($link){
            $node->setParent($this);
        }
    }

    public function hasChildren($id)
    {
        return $this->children($id);
    }

    public function children($id)
    {
        return isset($this->children[$id]) ? $this->children[$id]: null;
    }

    public function find($id)
    {
        if($$node = $this->children($id)){
            foreach($this->children as $subNode){
                if($node = $subNode->find($id)){
                    return $node;
                }
            }
        }
        return $node;
    }


    public function getId()
    {
        return $this->id;
    }

    public function __get($key)
    {
        return $this->data[$key]?:null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists(mixed $offset): bool 
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset(mixed $offset): void 
    {
        unset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed 
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

}