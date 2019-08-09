<?php declare(strict_types=1);

namespace App\Pagination;

final class PageRequest
{
    /**
     * @var int
     */
    private $pageNum;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * PaginationRequest constructor.
     * @param int $pageNum
     * @param int $pageSize
     */
    public function __construct(int $pageNum, int $pageSize)
    {
        $this->pageNum = $pageNum;
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
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}