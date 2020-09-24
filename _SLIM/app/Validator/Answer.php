<?php

namespace Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

class Answer
{
    public static function validate(\Model\Answer $answer)
    {
        self::validateID($answer->id);
        self::validateText($answer->text);

        // @todo ->dateTime
        try {
            v::optional(v::stringType())->assert($answer->updatedAt);
        } catch (NestedValidationException $exception) {
            throw new \Exception('Answer timestamp param ' . $exception->getMessages()[0], 0);
        }

        return true;
    }

    public static function validateID($answerID)
    {
        try {
            v::intType()->min(1, true)->assert($answerID);
        } catch (NestedValidationException $exception) {
            throw new \Exception('Answer id param ' . $exception->getMessages()[0], 0);
        }
    }

    public static function validateText($text)
    {
        try {
            v::stringType()->length(1, null)->assert($text);
        } catch (NestedValidationException $exception) {
            throw new \Exception('Answer text param ' . $exception->getMessages()[0], 0);
        }
    }
}
