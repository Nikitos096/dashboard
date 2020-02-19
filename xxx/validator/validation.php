<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

//docker run --rm -v ${PWD}:/app --workdir=/app  php:7.4-cli php xxx/validator/validation.php

require 'api/vendor/autoload.php';

AnnotationRegistry::registerLoader('class_exists');
$validator = Validation::createValidatorBuilder()
    ->enableAnnotationMapping()
    ->getValidator();

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="6")
     */
    public string $password;
}

$command = new Command();
$command->email = 'hello@world.com';
$command->password = '010523';
$violations = $validator->validate($command);

/** @var ConstraintViolationInterface $violation */
foreach ($violations as $violation) {
    echo $violation->getPropertyPath().': '. $violation->getMessage().PHP_EOL;
}
