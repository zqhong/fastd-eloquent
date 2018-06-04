<?php

namespace Zqhong\FastdEloquent\Test;

class CrudTest extends TestCase
{
    public function testCrud()
    {
        // test create
        $this
            ->connection
            ->table('posts')
            ->insert([
                'author' => 'author',
                'title' => 'title',
                'content' => 'content',
                'created_at' => time(),
                'updated_at' => time(),
            ]);

        // test read
        $post = $this
            ->connection
            ->table('posts')
            ->where('title', 'title')
            ->first();
        $this->assertEquals('author', $post->author);
        $this->assertEquals('title', $post->title);
        $this->assertEquals('content', $post->content);
        $this->assertGreaterThan(0, $post->created_at);
        $this->assertGreaterThan(0, $post->updated_at);

        // test update
        $this
            ->connection
            ->table('posts')
            ->where('title', 'title')
            ->update([
                'author' => 'author2',
                'title' => 'title2',
                'content' => 'content2',
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        $post2 = $this
            ->connection
            ->table('posts')
            ->where('title', 'title2')
            ->first();
        $this->assertEquals('author2', $post2->author);
        $this->assertEquals('title2', $post2->title);
        $this->assertEquals('content2', $post2->content);
        $this->assertGreaterThan(0, $post2->created_at);
        $this->assertGreaterThan(0, $post2->updated_at);

        // test delete
        $this
            ->connection
            ->table('posts')
            ->where('title', 'title2')
            ->delete();
        $post3 = $this
            ->connection
            ->table('posts')
            ->where('title', 'title2')
            ->first();
        $this->assertEmpty($post3);
    }
}