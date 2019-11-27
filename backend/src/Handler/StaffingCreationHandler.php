<?php

declare(strict_types=1);

namespace App\Handler;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Staffing;
use App\Entity\StaffingRequest;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class StaffingCreationHandler
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(ValidatorInterface $validator, ManagerRegistry $managerRegistry)
    {
        $this->validator = $validator;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(StaffingRequest $staffingRequest): Staffing
    {
        $staffing = new Staffing();
        $staffing->setDescription($staffingRequest->getDescription());
        $this->validator->validate($staffing);
        $this->managerRegistry->getManager()->persist($staffing);
        $this->managerRegistry->getManager()->flush();
        return $staffing;
    }
}
