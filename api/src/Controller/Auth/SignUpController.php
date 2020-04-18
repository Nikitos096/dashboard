<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\User\UseCase\SignUp;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SignUpController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route(path="/signup/request", name="signup.request", methods={"POST"})
     * @param Request $request
     * @param SignUp\Request\Handler $handler
     * @return JsonResponse
     */
    public function request(Request $request, SignUp\Request\Handler $handler)
    {
        /** @var SignUp\Request\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), SignUp\Request\Command::class, 'json');
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
     * @Route(path="/signup/confirm", name="signup.confirm", methods={"POST"})
     * @param Request $request
     * @param SignUp\Confirm\Handler $handler
     * @return JsonResponse
     */
    public function confirm(Request $request, SignUp\Confirm\Handler $handler)
    {
        /** @var SignUp\Confirm\Command $command */
        $command = $this->serializer->deserialize($request->getContent(), SignUp\Confirm\Command::class, 'json');
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