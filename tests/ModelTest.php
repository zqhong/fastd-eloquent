<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Support\Str;

class ModelTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testCreate()
    {
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

        // 临界值测试
        $post2 = new PostModel();
        $post2->author = Str::random(255);
        $post2->title = Str::random(255);
        $post2->content = Str::random(255);
        $post2->created_at = 4294967295;
        $post2->updated_at = 4294967295;
        $insertStatus3 = $post2->saveOrFail();
        $this->assertTrue($insertStatus3);
    }

    /**
     * @throws \Throwable
     */
    public function testRead()
    {
        $this->addPost();

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
    }

    /**
     * @throws \Throwable
     */
    public function testUpdate()
    {
        $post = $this->addPost();

        // test update
        $currentTimestamp = time();
        $updateStatus = $post->update([
            'updated_at' => $currentTimestamp,
        ]);
        unset($post);

        $post = PostModel::query()
            ->where('title', 'title')
            ->firstOrFail();
        $this->assertTrue($updateStatus);
        $this->assertEquals($currentTimestamp, $post['updated_at']);
    }

    /**
     * @throws \Throwable
     */
    public function testDelete()
    {
        $this->addPost();

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

    /**
     * @throws \Throwable
     */
    protected function addPost()
    {
        $post = new PostModel();
        $post->author = "author";
        $post->title = "title";
        $post->content = "content";
        $post->created_at = time();
        $post->updated_at = time();
        $post->saveOrFail();

        return $post;
    }
}