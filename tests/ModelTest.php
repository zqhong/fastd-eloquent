<?php

namespace Zqhong\FastdEloquent\Test;

class ModelTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testCrud()
    {
        // test create
        $insertStatus = PostModel::query()
            ->insert([
                'author' => 'author',
                'title' => 'title',
                'content' => 'content',
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        $this->assertTrue($insertStatus);

        $post = new PostModel();
        $post->author = "author2";
        $post->title = "title2";
        $post->content = "content2";
        $post->created_at = time();
        $post->updated_at = time();
        $insertStatus2 = $post->saveOrFail();
        $this->assertTrue($insertStatus2);

        // test read
        $post = PostModel::query()
            ->where('title', 'title')
            ->firstOrFail();
        $this->assertInstanceOf(PostModel::class, $post);
        $this->assertEmpty('author', $post['author']);
        $this->assertEmpty('title', $post['title']);
        $this->assertEmpty('content', $post['content']);
        $this->assertGreaterThan(0, $post['created_at']);
        $this->assertGreaterThan(0, $post['updated_at']);

        // test update

        // test delete
    }
}