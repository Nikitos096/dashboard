<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Model\User\UseCase\Reset;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ResetController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route(name="auth.reset.request", path="/reset/request", methods={"POST"})
     * @param Request $request
     * @param Reset\Request\Handler $handler
     * @return JsonResponse
     */
    public function request(Request $request, Reset\Request\Handler $handler)
    {
        /** @var Reset\Request\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), Reset\Request\Command::class, 'json');
        $violations = $this->validator->validate($command);
        if (\count($violations) > 0) {
            return new JsonResponse($this->serializer->serialize($violations, 'json'), 400, [], true);
        }

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            return new JsonResponse($this->serializer->serialize($e->getMessage(), 'json'), 400, [], true);
        }

        return new JsonResponse(['success'], 200);
    }

    /**
     * @Route(name="auth.reset.reset", path="/reset", methods={"POST"})
     * @param Request $request
     * @param Reset\Reset\Handler $handler
     * @return JsonResponse
     */
    public function reset(Request $request, Reset\Reset\Handler $handler)
    {
        /** @var Reset\Reset\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), Reset\Reset\Command::class, 'json');
        $violations = $this->validator->validate($command);
        if (\count($violations) > 0) {
            return new JsonResponse($this->serializer->serialize($violations, 'json'), 400, [], true);
        }

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            return new JsonResponse($this->serializer->serialize($e->getMessage(), 'json'), 400, [], true);
        }

        return new JsonResponse(['success'], 200);
    }
}