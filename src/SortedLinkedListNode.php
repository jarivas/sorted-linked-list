<?php

declare(strict_types=1);

namespace Rivas;

class SortedLinkedListNode
{


    public function __construct(
        private int|string $value,
        private SortedLinkedListNode|null $nextNode=null
        )
    {

    }//end __construct()


    public function setValue(int|string $value): SortedLinkedListNode
    {
        $this->value = $value;

        return $this;

    }//end setValue()


    public function getValue(): int|string
    {
        return $this->value;

    }//end getValue()


    public function setNextNode(SortedLinkedListNode|null $node): SortedLinkedListNode
    {
        $this->nextNode = $node;

        return $this;

    }//end setNextNode()


    public function getNextNode(): SortedLinkedListNode|null
    {
        return $this->nextNode;

    }//end getNextNode()


    public function equal(int|string $value): bool
    {
        return ($this->value == $value);

    }//end equal()


    public function greater(int|string $value): bool
    {
        return ($this->value > $value);

    }//end greater()


    public function less(int|string $value): bool
    {
        return ($this->value < $value);

    }//end less()


}//end class
