<?php declare(strict_types=1);

namespace App\School;

use App\Entity\School;
use App\Pagination\PageInformation;
use Traversable;

final class SchoolsResult implements \IteratorAggregate
{
    /**
     * @var int
     *
     *
     */
    private $total;

    /**
     * @var PageInformation
     */
    private $pageInformation;

    /**
     * @var \Iterator<School>
     */
    private $items;

    /**
     * SchoolsResult constructor.
     * @param int $total
     * @param PageInformation $pageInformation
     * @param \Iterator $items
     */
    public function __construct(int $total, PageInformation $pageInformation, \Iterator $items)
    {
        $this->total = $total;
        $this->pageInformation = $pageInformation;
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return PageInformation
     */
    public function getPageInformation(): PageInformation
    {
        return $this->pageInformation;
    }

    /**
     * @return \Iterator
     */
    public function getItems(): \Iterator
    {
        return $this->items;
    }

    public function getIterator()
    {
        return $this->getItems();
    }
}