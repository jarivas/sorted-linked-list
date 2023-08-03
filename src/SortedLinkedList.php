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

        if ($list->equal($value)) {
            return true;
        }

        if ($list->greater($value)) {
            $this->list = new SortedLinkedListNode($value, $list);

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

        if (! $this->validateValue($value)) {
            return null;
        }

        if ($this->list->equal($value)) {
            return $this->list;
        }

        [$node] = $this->getNode($this->list, $value);

        return $node?->equal($value) ? $node : null;

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

        if (! $this->validateValue($value)) {
            return false;
        }

        [
            $node,
            $previous,
        ] = $this->getNode($this->list, $value);

        return (is_null($node)) ? false : $this->removeNodeHelper($node, $previous, $value);

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


    private function addHelper(SortedLinkedListNode $current, int|string $value): bool
    {
        [
            $node,
            $previous,
        ]        = $this->getNode($current, $value);
        $newNode = new SortedLinkedListNode($value);

        if ($node) {
            return ($node->equal($value)) ? true : $this->addHelperNodeExists($node, $previous, $newNode);
        }

        if ($previous) {
            return ($previous->equal($value)) ? true : $this->addHelperPreviousExists($previous, $newNode);
        }

        return false;

    }//end addHelper()


    private function addHelperNodeExists(SortedLinkedListNode $node, SortedLinkedListNode|null $previous, SortedLinkedListNode $newNode): bool
    {
        if ($node->less($newNode->getValue())) {
            $previous?->setNextNode($newNode);

            return true;
        }

        $newNode->setNextNode($node);
        $previous?->setNextNode($newNode);

        return true;

    }//end addHelperNodeExists()


    private function addHelperPreviousExists(SortedLinkedListNode $previous, SortedLinkedListNode $newNode): bool
    {
        if ($previous->less($newNode->getValue())) {
            $previous->setNextNode($newNode);

            return true;
        }

        $nextNode = $previous->getNextNode();

        $newNode->setNextNode($nextNode);
        $previous->setNextNode($newNode);

        return true;

    }//end addHelperPreviousExists()


    /**
     * @return array<null|SortedLinkedListNode>
     */
    private function getNode(SortedLinkedListNode $current, int|string $value): array
    {
        $previous = null;

        while ($current && $current->less($value)) {
            $previous = $current;
            $current  = $current->getNextNode();
        }

        return [
            $current,
            $previous,
        ];

    }//end getNode()


    private function removeNodeHelper(SortedLinkedListNode $node, SortedLinkedListNode|null $previous, int|string $value): bool
    {
        if ($node->equal($value)) {
            if (is_null($previous)) {
                $this->list = $node->getNextNode();

                return true;
            }

            $previous->setNextNode($node->getNextNode());

            return true;
        }

        if ($previous?->equal($value)) {
            $previous->setNextNode($node->getNextNode());

            return true;
        }

        return false;

    }//end removeNodeHelper()


}//end class
