<?php

declare(strict_types=1);

namespace Rivas\Tests;

use PHPUnit\Framework\TestCase;
use Rivas\SortedLinkedListNode;

class SortedLinkedListNodeTest extends TestCase
{
    private const VALUE = 9;


    public function testGetValue(): void
    {
        $node = new SortedLinkedListNode(self::VALUE);

        $this->assertSame(self::VALUE, $node->getValue());

    }//end testGetValue()


    public function testSetValue(): void
    {
        $node = new SortedLinkedListNode(0);

        $node->setValue(self::VALUE);

        $this->assertSame(self::VALUE, $node->getValue());

    }//end testSetValue()


    public function testGetPreviousNode(): void
    {
        $node = new SortedLinkedListNode(0, new SortedLinkedListNode(self::VALUE));

        $this->assertSame(self::VALUE, $node->getPreviousNode()->getValue());

    }//end testGetPreviousNode()


    public function testSetPreviousNode(): void
    {
        $node = new SortedLinkedListNode(0);

        $node->setPreviousNode(new SortedLinkedListNode(self::VALUE));

        $this->assertSame(self::VALUE, $node->getPreviousNode()->getValue());

    }//end testSetPreviousNode()


    public function testGetNextNode(): void
    {
        $node = new SortedLinkedListNode(0, null, new SortedLinkedListNode(self::VALUE));

        $this->assertSame(self::VALUE, $node->getNextNode()->getValue());

    }//end testGetNextNode()


    public function testSetNextNode(): void
    {
        $node = new SortedLinkedListNode(0);

        $node->setNextNode(new SortedLinkedListNode(self::VALUE));

        $this->assertSame(self::VALUE, $node->getNextNode()->getValue());

    }//end testSetNextNode()


    public function testEqual(): void
    {
        $node = new SortedLinkedListNode(self::VALUE);

        $this->assertTrue($node->equal(self::VALUE));

    }//end testEqual()


    public function testLess(): void
    {
        $node = new SortedLinkedListNode(self::VALUE);

        $this->assertTrue($node->less(self::VALUE + 1));

    }//end testLess()


    public function testGreater(): void
    {
        $node = new SortedLinkedListNode(self::VALUE);

        $this->assertTrue($node->greater(self::VALUE - 1));

    }//end testGreater()


}//end class
