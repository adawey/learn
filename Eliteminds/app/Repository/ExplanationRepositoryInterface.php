<?php


namespace App\Repository;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ExplanationRepositoryInterface
{
    /**
     * return all posts order by created at desc
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function all(array $filters = []): LengthAwarePaginator;

    /**
     * return single post full data
     * @param int $post_id
     * @return Collection
     */
    public function find(int $post_id): Collection;


    /**
     * store data
     * @param array $data
     * @return int
     */
    public function save(array $data): int;


    /**
     * Update single post data
     * @param int $post_id
     * @param array $data
     */
    public function update(int $post_id, array $data): void;

    /**
     * Destroy single post
     * @param int $post_id
     */
    public function delete(int $post_id): void;
}
