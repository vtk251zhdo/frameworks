<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/labels')]
class LabelController
{
    public function __construct(private readonly LabelRepository $labels)
    {
    }

    #[Route('', name: 'label_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $data = array_map(
            static fn (Label $label) => $label->toArray(),
            $this->labels->findAll()
        );

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'label_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $label = $this->labels->find($id);

        if (!$label) {
            return new JsonResponse(['message' => 'Label not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($label->toArray(), Response::HTTP_OK);
    }

    #[Route('', name: 'label_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];

        if (empty($payload['name'])) {
            return new JsonResponse(['message' => 'Field "name" is required'], Response::HTTP_BAD_REQUEST);
        }

        $label = new Label();
        $label->setName($payload['name']);
        $label->setDescription($payload['description'] ?? null);
        $label->setColor($payload['color'] ?? null);
        $label->setIsActive($payload['isActive'] ?? true);

        $this->labels->save($label);

        return new JsonResponse($label->toArray(), Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'label_update', methods: ['PATCH'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $label = $this->labels->find($id);

        if (!$label) {
            return new JsonResponse(['message' => 'Label not found'], Response::HTTP_NOT_FOUND);
        }

        $payload = json_decode($request->getContent(), true) ?? [];

        if (array_key_exists('name', $payload)) {
            $label->setName($payload['name']);
        }
        if (array_key_exists('description', $payload)) {
            $label->setDescription($payload['description']);
        }
        if (array_key_exists('color', $payload)) {
            $label->setColor($payload['color']);
        }
        if (array_key_exists('isActive', $payload)) {
            $label->setIsActive((bool) $payload['isActive']);
        }

        $this->labels->save($label);

        return new JsonResponse($label->toArray(), Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'label_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $label = $this->labels->find($id);

        if (!$label) {
            return new JsonResponse(['message' => 'Label not found'], Response::HTTP_NOT_FOUND);
        }

        $this->labels->remove($label);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
