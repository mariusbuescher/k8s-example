<?php declare(strict_types=1);

namespace App\Pagination;

final class PageInformation
{
    /**
     * @var int
     */
    private $pageNum;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * PageInformation constructor.
     * @param int $pageNum
     * @param int $total
     * @param int $pageSize
     */
    public function __construct(int $pageNum, int $total, int $pageSize)
    {
        $this->pageNum = $pageNum;
        $this->total = $total;
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPageNum(): int
    {
        return $this->pageNum;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}