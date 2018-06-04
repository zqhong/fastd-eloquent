<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PaginatorTest extends TestCase
{
    protected $maxId = 19;

    protected function setUp()
    {
        parent::setUp();

        for ($i = 1; $i <= $this->maxId; $i++) {
            PostModel::query()
                ->insert([
                    'id' => $i,
                    'title' => 'title-' . Str::random(),
                    'content' => 'content-' . Str::random(),
                    'author' => 'author-' . Str::random(),
                    'created_at' => time(),
                    'updated_at' => time(),
                ]);
        }
    }

    public function testPaginate()
    {
        $perPage = 10;
        $columns = ['*'];
        $pagename = 'page';

        // 第一页
        /** @var LengthAwarePaginator $paginator */
        $paginator = PostModel::query()
            ->paginate($perPage, $columns, $pagename);
        $paginateData = $paginator->toArray();
        $this->assertPaginateData($paginateData);
        $this->assertEquals(range(1, 10), array_column(Arr::get($paginateData, 'data'), 'id'));

        // 第二页
        $_GET['page'] = 2;
        /** @var LengthAwarePaginator $paginator */
        $paginator = PostModel::query()
            ->paginate($perPage, $columns, $pagename);
        $paginateData = $paginator->toArray();
        $this->assertPaginateData($paginateData);
        $this->assertEquals(range(11, 19), array_column(Arr::get($paginateData, 'data'), 'id'));
    }

    protected function assertPaginateData($paginateData)
    {
        $this->assertTrue(is_array($paginateData));

        $this->assertArrayHasKey('current_page', $paginateData);
        $this->assertArrayHasKey('data', $paginateData);
        $this->assertArrayHasKey('from', $paginateData);
        $this->assertArrayHasKey('last_page', $paginateData);
        $this->assertArrayHasKey('next_page_url', $paginateData);
        $this->assertArrayHasKey('path', $paginateData);
        $this->assertArrayHasKey('per_page', $paginateData);
        $this->assertArrayHasKey('prev_page_url', $paginateData);
        $this->assertArrayHasKey('to', $paginateData);
        $this->assertArrayHasKey('total', $paginateData);
    }
}