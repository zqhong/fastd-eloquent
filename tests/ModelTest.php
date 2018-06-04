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
        $this->assertEquals('author', $post['author']);
        $this->assertEquals('title', $post['title']);
        $this->assertEquals('content', $post['content']);
        $this->assertGreaterThan(0, $post['created_at']);
        $this->assertGreaterThan(0, $post['updated_at']);

        // test update
        $currentTimestamp = time();
        $updateStatus = $post->update([
            'updated_at' => $currentTimestamp,
        ]);
        $post = PostModel::query()
            ->where('title', 'title')
            ->firstOrFail();
        $this->assertTrue($updateStatus);
        $this->assertEquals($currentTimestamp, $post['updated_at']);

        // test delete
        $deletedCnt = PostModel::query()
            ->where('title', 'title')
            ->delete();
        $this->assertEquals(1, $deletedCnt);
        $post = PostModel::query()
            ->where('title', 'title')
            ->first();
        $this->assertEmpty($post);
    }
}