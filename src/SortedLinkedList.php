<?php

declare(strict_types=1);

namespace Rivas;

class SortedLinkedList
{

    private SortedLinkedListType|null $type = null;

    private SortedLinkedListNode|null $list = null;


    public function __construct(SortedLinkedListType|int|string|null $value)
    {
        if (is_null($value)) {
            return;
        }

        if ($value instanceof SortedLinkedListType) {
            $this->type = $value;

            return;
        }

        $this->type = $this->getType($value);

        $this->add($value);

    }//end __construct()


    public function add(int|string $value): bool
    {
        if (! $this->validateValue($value)) {
            return false;
        }

        $list = $this->list;

        if (is_null($list)) {
            $this->list = new SortedLinkedListNode($value);

            return true;
        }

        if ($list->greater($value)) {
            $this->list = new SortedLinkedListNode($value, null, $list);

            return true;
        }

        if ($list->equal($value)) {
            return true;
        }

        return $this->addHelper($list, $value);

    }//end add()


    /**
     * @return array<int|string>
     */
    public function toArray(): array
    {
        $result = [];

        if (is_null($this->list)) {
            return $result;
        }

        $current = $this->list;

        while ($current != null) {
            $result[] = $current->getValue();

            $current = $current->getNextNode();
        }

        return $result;

    }//end toArray()


    public function get(int|string $value): null|SortedLinkedListNode
    {
        if (is_null($this->list)) {
            return null;
        }

        if (! $this->validateValue($value) || $this->list->greater($value)) {
            return null;
        }

        if ($this->list->equal($value)) {
            return $this->list;
        }

        return $this->getNode($this->list, $value);

    }//end get()


    public function exists(int|string $value): bool
    {
        $node = $this->get($value);

        return !is_null($node);

    }//end exists()


    public function remove(int|string $value): bool
    {
        if (is_null($this->list)) {
            return false;
        }

        if (! $this->validateValue($value) || $this->list->greater($value)) {
            return false;
        }

        if ($this->list->equal($value)) {
            unset($this->list);

            return true;
        }

        $node = $this->getNode($this->list, $value);

        if (is_null($node)) {
            return false;
        }

        $node->getPreviousNode()?->setNextNode($node->getNextNode());

        unset($node);

        return true;

    }//end remove()


    private function getType(int|string $value): SortedLinkedListType
    {
        return is_int($value) ? SortedLinkedListType::Integer : SortedLinkedListType::String;

    }//end getType()


    private function validateValue(int|string $value): bool
    {
        $type = $this->getType($value);

        return ($this->type == $type);

    }//end validateValue()


    private function getNode(SortedLinkedListNode $current, int|string $value): null|SortedLinkedListNode
    {
        $previous = null;
        $next     = null;

        while ($current != null) {
            $previous = $current;
            $next     = $current->getNextNode();
            $current  = ($next && $next->greater($value)) ? null : $next;
        }

        return $previous;

    }//end getNode()


    private function addHelper(SortedLinkedListNode $current, int|string $value): bool
    {
        $node = $this->getPreviousNode($current, $value);

        if ($node->equal($value)) {
            return true;
        }

        $node->setNextNode(new SortedLinkedListNode($value, $node, $node->getNextNode()));

        return true;

    }//end addHelper()


    private function getPreviousNode(SortedLinkedListNode $current, int|string $value): SortedLinkedListNode
    {
        $previous = $current;
        $next     = null;

        while ($current != null) {
            $previous = $current;
            $next     = $current->getNextNode();
            $current  = ($next && $next->less($value)) ? $next : null;
        }

        return $previous;

    }//end getPreviousNode()


}//end class
