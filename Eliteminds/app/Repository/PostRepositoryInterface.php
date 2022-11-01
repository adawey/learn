<?php


namespace App\Repository;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    /**
     * return all posts order by created at desc
     * @param array $filters
     * @param int|null $section_id
     * @return Collection
     */
    public function all(array $filters = [], int $section_id = null): Collection;

    /**
     * return single post full data
     * @param int $id
     * @return Collection
     */
    public function find(int $id): Collection;

    /**
     * @param string $slug
     * @return Collection
     */
    public function findBySlug(string $slug): Collection;

    /**
     * store data
     * @param array $data
     * @return bool
     */
    public function save(array $data): int;


    /**
     * @param int $post_id
     * @param array $sections
     */
    public function setPostSections(int $post_id, array $sections): void;


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

    /**
     * @param string $content
     * @return string
     */
    public  function getCover(string $content): string;

    /**
     * @param string $title
     * @param int $post_id
     */
    public function doSlug(string $title, int $post_id): void;
}
