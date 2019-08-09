<?php declare(strict_types=1);

namespace App\Http\ArgumentValueResolver;

use App\Pagination\PageRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class PageRequestArgumentValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var int
     */
    private $defaultPageSize;

    public function __construct(int $defaultPageSize = 10)
    {
        $this->defaultPageSize = $defaultPageSize;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === PageRequest::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $page = (int) $request->query->get('page', 1);
        $size = (int) $request->query->get('pageSize', $this->defaultPageSize);

        yield new PageRequest($page, $size);
    }
}