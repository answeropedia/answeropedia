<?php

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

class UserFollowQuestion_Relation_Validator
{
    #
    # Model validator
    #

    public static function validateExists(UserFollowQuestion_Relation_Model $rel)
    {
        self::validateID($rel->getID());
        self::validateNew($rel);

        return true;
    }

    public static function validateNew(UserFollowQuestion_Relation_Model $rel)
    {
        self::validateUserID($rel->getUserID());
        self::validateQuestionID($rel->getQuestionID());
        self::validateCreatedAt($rel->getCreatedAt());

        return true;
    }

    #
    # Property validators
    #

    public static function validateID($id)
    {
        try {
            v::intType()->min(1, true)->assert($id);
        } catch (NestedValidationException $exception) {
            throw new Exception('UserFollowQuestion relation "id" property '.$exception->getMessages()[0], 0);
        }
    }

    public static function validateUserID($id)
    {
        try {
            v::intType()->min(1, true)->assert($id);
        } catch (NestedValidationException $exception) {
            throw new Exception('UserFollowQuestion relation "userID" property '.$exception->getMessages()[0], 0);
        }
    }

    public static function validateQuestionID($id)
    {
        try {
            v::intType()->min(1, true)->assert($id);
        } catch (NestedValidationException $exception) {
            throw new Exception('UserFollowQuestion relation "questionID" property '.$exception->getMessages()[0], 0);
        }
    }

    public static function validateCreatedAt($createdAt)
    {
        try {
            v::optional(v::stringType())->assert($createdAt);
        } catch (NestedValidationException $exception) {
            throw new Exception('UserFollowQuestion relation "createdAt" property '.$exception->getMessages()[0], 0);
        }
    }
}