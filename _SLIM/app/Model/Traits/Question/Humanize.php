<?php

namespace Model\Traits\Question;

trait Humanize
{
    public function getMinutesToRead(): int
    {
        $answer_len = mb_strlen($this->answer->text);

        $minites_to_read = ceil($answer_len / 1000);

        return (int) $minites_to_read;
    }
}
