<?php

declare(strict_types=1);

namespace Rivas;

class SortedLinkedList
{
    private SortedLinkedListType|null $type = null;
    private SortedLinkedListNode|null $list = null;
    private SortedLinkedListNode|null $end = null;

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
    }

    public function add(int|string $value): bool
    {
        $type = $this->getType($value);

        if ($this->type != $type) {
            return false;
        }

        if (is_null($this->list)) {
            $this->list = new SortedLinkedListNode($value);

            return true;
        }

        if ()

    }

    public function exists(int|string $value): bool
    {
        $node = $this->getNode($value);

        return empty($node);
    }

    public function remove(int|string $value): bool
    {
        $node = $this->getNode($value);

        $node->previous->next = $node->next;

        unset($node);
    }

    private function getType(int|string $value): SortedLinkedListType
    {
        return is_int($value) ? SortedLinkedListType::Integer : SortedLinkedListType::String;
    }

    private function getNode(int|string $value): null|SortedLinkedListNode
    {
        $node = $this->list;

        while (($node != null) && ($node->value != $value)) {
            $node = $node->next;
        }

        return $node;
    }
}//end class