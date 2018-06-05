<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class DDLTest extends TestCase
{
    public function testCreateTable()
    {
        Manager::schema()->dropIfExists('posts');
        $this->createPostsTable();
        $this->assertTrue(Manager::schema()->hasTable('posts'));
    }

    public function testDropTable()
    {
        Manager::schema()->dropIfExists('posts');
        $this->createPostsTable();

        $this->assertTrue(Manager::schema()->hasTable('posts'));
        Manager::schema()->dropIfExists('posts');
        $this->assertFalse(Manager::schema()->hasTable('posts'));
    }

    public function testAlterTable()
    {
        Manager::schema()->dropIfExists('posts');
        $this->createPostsTable();

        Manager::schema()->table('posts', function (Blueprint $table) {
            $table->string('author2')->default('');
        });
        $this->assertTrue(Manager::schema()->hasColumn('posts', 'author2'));

        Manager::schema()->table('posts', function (Blueprint $table) {
            $table->dropColumn('author');
        });
        $this->assertFalse(Manager::schema()->hasColumn('posts', 'author'));
    }

    protected function createPostsTable()
    {
        Manager::schema()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author');
            $table->string('title');
            $table->text('content');
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }
}