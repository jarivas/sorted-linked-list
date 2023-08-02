<?php

declare(strict_types=1);

namespace Rivas;

class SortedLinkedList
{
    private SortedLinkedListType|null $type = null;
    private SortedLinkedListNode|null $list = null;
    private SortedLinkedListNode|null $last = null;

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
        if (! $this->validateValue($value)) {
            return false;
        }

        if (is_null($this->list)) {
            $this->list = new SortedLinkedListNode($value);
            $this->last = $this->list;

            return true;
        }

        return $this->addHelper($value);
    }

    public function exists(int|string $value): bool
    {
        $node = $this->getNode($value);

        return empty($node);
    }

    public function remove(int|string $value): bool
    {
        $node = $this->getNode($value);

        if (empty($node)) {
            return false;
        }

        $node->previous->next = $node->next;

        if ($this->last->value == $value) {
            $this->last = $node->previous;
        }

        unset($node);

        return true;
    }

    private function getType(int|string $value): SortedLinkedListType
    {
        return is_int($value) ? SortedLinkedListType::Integer : SortedLinkedListType::String;
    }

    private function validateValue(int|string $value): bool
    {
        $type = $this->getType($value);

        return ($this->type == $type);
    }

    private function getNode(int|string $value): null|SortedLinkedListNode
    {
        if (! $this->validateValue($value)) {
            return null;
        }

        if ($this->last->value == $value) {
            return $this->last;
        }

        $node = $this->list;

        while (($node != null) && ($node->value != $value)) {
            $node = $node->next;
        }

        return $node;
    }

    public function addHelper(int|string $value): bool
    {
        $list = $this->list;
        $last = $this->last;

        if (($list->value == $value) || ($last->value == $value)) {
            return true;
        }

        if ($last->value < $value) {
            $node = new SortedLinkedListNode($value, $last);

            $last->previous->next = $node;

            $this->last = $node;

            return true;
        }

        $node = $this->findNearestNode($value);

        $newNode = new SortedLinkedListNode($value, $node, $node->next);

        $node->next = $newNode;

        return true;
    }

    private function findNearestNode(int|string $value): SortedLinkedListNode
    {
        $node = $this->list;

        while (($node != null) && ($value < $node->value)) {
            $node = $node->next;
        }

        return $node;
    }
}//last class