<?php

declare(strict_types=1);

namespace Rivas;

class SortedLinkedListNode
{
    public function __construct(
        public int|string $value,
        public SortedLinkedListNode|null $previous = null,
        public SortedLinkedListNode|null $next = null
        )
    {
    }


}//end class