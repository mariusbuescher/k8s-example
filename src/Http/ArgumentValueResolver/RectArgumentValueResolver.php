<?php declare(strict_types=1);

namespace App\Http\ArgumentValueResolver;

use App\Geo\Point;
use App\Geo\Rect;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class RectArgumentValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === Rect::class
            && $request->query->has('up_left_lat')
            && $request->query->has('up_left_long')
            && $request->query->has('bot_right_lat')
            && $request->query->has('bot_right_long');
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $upperLeftLat = floatval($request->query->get('up_left_lat'));
        $upperLeftLong = floatval($request->query->get('up_left_long'));
        $bottomRightLat = floatval($request->query->get('bot_right_lat'));
        $bottomRightLong = floatval($request->query->get('bot_right_long'));

        yield new Rect(
            new Point($upperLeftLat, $upperLeftLong),
            new Point($bottomRightLat, $bottomRightLong)
        );
    }
}