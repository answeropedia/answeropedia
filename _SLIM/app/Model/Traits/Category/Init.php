<?php

namespace Model\Traits\Category;

trait Init
{
    public static function initWithTitle(string $title): self
    {
        $category        = new self;
        $category->title = $title;

        return $category;
    }

    public static function initWithDBState(array $state): self
    {
        if (! isset($state['c_id']) || ! isset($state['c_title'])) {
            throw new \Exception('Category init with empty state', 1);
        }

        $category             = new self;
        $category->id         = (int) $state['c_id'];
        $category->title      = (string) $state['c_title'];
        $category->isRedirect = (bool) $state['cat_is_redirect'];

        return $category;
    }
}
