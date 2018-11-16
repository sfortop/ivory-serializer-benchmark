<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks;

use PhpSerializers\Benchmarks\Model\Category;
use PhpSerializers\Benchmarks\Model\Comment;
use PhpSerializers\Benchmarks\Model\Forum;
use PhpSerializers\Benchmarks\Model\Thread;

class DataProvider
{

    public function getData(int $horizontalComplexity = 1, $verticalComplexity = 1): Forum
    {
        $forum = new Forum(1, 'Great name!');
        $forum->setCategory($this->createCategory($verticalComplexity));

        for ($i = 0; $i < $horizontalComplexity * 2; ++$i) {
            $forum->addThread($this->createThread($i, $horizontalComplexity));
        }

        return $forum;
    }

    private function createCategory(int $verticalComplexity = 1): Category
    {
        $original = $category = new Category(1);

        for ($i = 0; $i < $verticalComplexity * 2; ++$i) {
            $category->setParent($parent = new Category($i + 1));
            $category = $parent;
        }

        return $original;
    }

    private function createThread(int $index, int $horizontalComplexity = 1): Thread
    {
        $thread = new Thread($index, 'Great thread ' . $index . '!', 'Great description ' . $index, $index / 100);

        for ($i = 0; $i < $horizontalComplexity * 5; ++$i) {
            $thread->addComment($this->createComment($index * $i + $i));
        }

        return $thread;
    }

    private function createComment(int $index): Comment
    {
        return new Comment($index, 'Great comment ' . $index . '!');
    }
}
