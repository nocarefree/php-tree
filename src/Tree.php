<?php

namespace Ncf\PTree;

class Tree extends Node{
    private $nodes = [];
    private $children = [];
    private $id = 0;

    public function __construct($nodes, $children)
    {
        $this->nodes = [];
        $this->children = [];   
    }

    public static function createFromArray(Array $items,String $primaryKey = 'id', String $parentKey = 'parent_id')
    {
        $nodes = [];

        foreach($items as $item){
            $id = $item[$primaryKey];
            if(!$id){
                throw new \ErrorException($primaryKey.' 不存在');
            }
            $node = new Node($item, $id);
            $nodes[$id] = $node;
        }

        $children = [];
        foreach($nodes as $id=>$node){
            $parentId = $node->{$parentKey};
            if($parentId && $parent = $nodes[$parentId]){
                $parent->addChildren($node, true);
            }else{
                $children[$id] = $node;
            }
        }

        return new Self($nodes, $children);
    }

}