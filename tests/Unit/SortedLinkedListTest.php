<?php

declare(strict_types=1);

namespace Rivas\Tests;

use PHP_CodeSniffer\Tokenizers\PHP;
use PHPUnit\Framework\TestCase;
use Rivas\SortedLinkedList;
use Rivas\SortedLinkedListType;

class SortedLinkedListTest extends TestCase
{
    private const VALUE = 9;


    public function testWrongValue(): void
    {
        $list   = new SortedLinkedList(SortedLinkedListType::String);
        $result = $list->add(self::VALUE);

        $this->assertFalse($result);

    }//end testWrongValue()


    public function testAdd(): void
    {
        $list = new SortedLinkedList(SortedLinkedListType::Integer);

        $result = $list->add(self::VALUE);

        $this->assertTrue($result);

    }//end testAdd()


    public function testGet(): void
    {
        $list = new SortedLinkedList(self::VALUE);

        $node = $list->get(self::VALUE);

        $this->assertNotNull($node);
        $this->assertSame(self::VALUE, $node->getValue());

    }//end testGet()


    public function testAddExtended(): void
    {
        $list = new SortedLinkedList(SortedLinkedListType::Integer);

        for ($i = 0; $i < self::VALUE; ++$i) {
            $result = $list->add(rand(-99, 99));
            $this->assertTrue($result);
        }

    }//end testAddExtended()


    public function testToArray(): void
    {
        $list         = new SortedLinkedList(SortedLinkedListType::Integer);
        $value        = 0;
        $values       = $this->getValues();
        $maxValues    = count($values);
        $sortedValues = $this->getSortedValues($values);

        for ($i = 0; $i < $maxValues; ++$i) {
            $value = $values[$i];

            $result = $list->add($value);
            $this->assertTrue($result);
        }

        $this->assertSame(
            $sortedValues,
            $list->toArray(),
            implode(',', $sortedValues).PHP_EOL.implode(',', $list->toArray())
        );

    }//end testToArray()


    public function testGetExtended(): void
    {
        $list   = new SortedLinkedList(SortedLinkedListType::Integer);
        $value  = 0;
        $values = [];

        for ($i = 0; $i < self::VALUE; ++$i) {
            $value = rand(-99, 99);

            $result = $list->add($value);
            $this->assertTrue($result);

            $values[] = $value;
        }

        for ($i = 0; $i < self::VALUE; ++$i) {
            $value = $values[$i];
            $node  = $list->get($value);

            $this->assertNotNull($node);
            $this->assertSame($value, $node->getValue());
        }

    }//end testGetExtended()


    public function testExists(): void
    {
        $list = new SortedLinkedList(self::VALUE);

        $result = $list->exists(self::VALUE);

        $this->assertTrue($result);

    }//end testExists()


    public function testExistsExtended(): void
    {
        $list   = new SortedLinkedList(SortedLinkedListType::Integer);
        $value  = 0;
        $values = [];

        for ($i = 0; $i < self::VALUE; ++$i) {
            $value = rand(-99, 99);

            $result = $list->add($value);
            $this->assertTrue($result);

            $values[] = $value;
        }

        for ($i = 0; $i < self::VALUE; ++$i) {
            $value = $values[$i];

            $result = $list->exists($value);
            $this->assertTrue($result);
        }

    }//end testExistsExtended()


    public function testRemove(): void
    {
        $list = new SortedLinkedList(self::VALUE);

        $result = $list->remove(self::VALUE);
        $this->assertTrue($result);

        $result = $list->exists(self::VALUE);
        $this->assertFalse($result);

    }//end testRemove()


    public function testRemoveExtended(): void
    {
        $list            = new SortedLinkedList(SortedLinkedListType::Integer);
        $value           = 0;
        $values          = $this->getValues();
        $uniqueValues    = array_values(array_unique($values));
        $maxValues       = count($values);
        $maxUniqueValues = count($uniqueValues);

        for ($i = 0; $i < $maxValues; ++$i) {
            $value = $values[$i];

            $result = $list->add($value);
            $this->assertTrue($result);
        }

        for ($i = 0; $i < $maxUniqueValues; ++$i) {
            $value = $uniqueValues[$i];

            $result = $list->remove($value);
            $this->assertTrue($result, "REMOVE INDEX: $i VALUE: $value | ".implode(',', $list->toArray()));

            $result = $list->exists($value);
            $this->assertFalse($result, "EXISTS INDEX: $i VALUE: $value | ".implode(',', $list->toArray()));
        }

    }//end testRemoveExtended()


    private function getValues(): array
    {
        return [
            29,
            25,
            -27,
            53,
            -19,
            -24,
            -24,
            23,
            38,
        ];

    }//end getValues()


    private function getSortedValues(array $values): array
    {
        $orderedValues = array_unique($values, SORT_REGULAR);
        asort($orderedValues);

        return array_values($orderedValues);

    }//end getSortedValues()


}//end class
