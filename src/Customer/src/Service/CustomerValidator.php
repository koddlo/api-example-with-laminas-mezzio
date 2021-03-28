<?php

declare(strict_types=1);

namespace Customer\Service;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripNewlines;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToNull;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Digits;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Hostname;
use Laminas\Validator\StringLength;

class CustomerValidator extends InputFilter
{
    private const FIRST_NAME = 'firstName';
    private const LAST_NAME = 'lastName';
    private const EMAIL = 'email';
    private const PHONE_NUMBER = 'phoneNumber';
    private const POSITION = 'position';
    private const COMPANY = 'company';

    private const REQUIRED_FIELDS = [
        self::FIRST_NAME,
        self::LAST_NAME,
        self::EMAIL
    ];

    public function init(): void
    {
        $this->add([
            'name' => self::FIRST_NAME,
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StripNewlines::class],
                ['name' => StringTrim::class],
                ['name' => ToNull::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 255
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => self::LAST_NAME,
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StripNewlines::class],
                ['name' => StringTrim::class],
                ['name' => ToNull::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 255
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => self::EMAIL,
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StripNewlines::class],
                ['name' => StringTrim::class],
                ['name' => ToNull::class]
            ],
            'validators' => [
                [
                    'name' => EmailAddress::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'allow' => Hostname::ALLOW_DNS
                    ]
                ],
                [
                    'name' => StringLength::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 255
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => self::PHONE_NUMBER,
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StripNewlines::class],
                ['name' => StringTrim::class],
                ['name' => ToNull::class]
            ],
            'validators' => [
                ['name' => Digits::class,],
                [
                    'name' => StringLength::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 9,
                        'max' => 9
                    ]
                ],

            ]
        ]);

        $this->add([
            'name' => self::POSITION,
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StripNewlines::class],
                ['name' => StringTrim::class],
                ['name' => ToNull::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 255
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => self::COMPANY,
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StripNewlines::class],
                ['name' => StringTrim::class],
                ['name' => ToNull::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 511
                    ]
                ]
            ]
        ]);
    }

    public function getErrorMessage(): ?string
    {
        foreach ($this->getMessages() as $fieldName => $errorMessage) {
            return sprintf("Field %s: %s", $fieldName, reset($errorMessage));
        }

        return null;
    }

    public function setRequired(bool $isRequired): void
    {
        foreach ($this->getInputs() as $input) {
            if (!in_array($input->getName(), self::REQUIRED_FIELDS)) {
                continue;
            }

            $input->setRequired($isRequired);
        }
    }
}
