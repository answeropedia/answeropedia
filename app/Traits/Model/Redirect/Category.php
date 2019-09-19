<?php

namespace Traits\Model\Redirect;

trait Category
{
    public static function init_with_DB_state(array $state): self
    {
        $redirect = new self();
        $redirect->from_ID = (int) $state['rd_from'];
        $redirect->to_title = (string) $state['rd_title'];

        return $redirect;
    }
}