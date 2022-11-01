<?php


namespace App\Repository\Post;


use App\Repository\PostRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public $table = 'posts';

    /**
     * return all posts order by created at desc
     * @param array $filters
     * @param int|null $section_id
     * @return Collection
     */
    public function all(array $filters = [], int $section_id = null): Collection
    {
        return DB::table($this->table)
            ->leftJoin('post_sections', 'posts.id', '=', 'post_sections.post_id')

            ->where(function($query)use($filters, $section_id){
                foreach($filters as $key_filter => $value_filter){
                    if($key_filter == 'word'){
                        if($value_filter) {
                            $query->where($this->table . '.title', 'LIKE', '%' . $value_filter . '%')
                                ->orWhere($this->table . '.content', 'LIKE', '%' . $value_filter . '%');
                        }
                    }else{
                        $query->where($this->table.'.'.$key_filter, $value_filter);
                    }
                }

                if($section_id)
                    $query->where('post_sections.section_id', $section_id);
            })
            ->orderBy('posts.created_at', 'desc')
            ->select(
                DB::raw('('.$this->table.'.id) AS id'),
                $this->table.'.slug',
                $this->table.'.title',
                $this->table.'.content',
                $this->table.'.cover',
                $this->table.'.created_at',
                $this->table.'.updated_at',
                $this->table.'.vimeo_id'
            )->get()->map(function($row){
                $row->cover = $this->getCover($row->content);
                $row->sections = $this->getPostSections($row->id);
//                if($row->cover)
//                    $row->cover = asset('storage/blog/cover/'.basename($row->cover));
                return $row;
            });
    }

    /**
     * return single post full data
     * @param int $id
     * @return Collection
     */
    public function find(int $id): Collection
    {
        return DB::table($this->table)->where($this->table.'.id', $id)
            ->limit(1)
            ->select(
                DB::raw('('.$this->table.'.id) AS id'),
                $this->table.'.title',
                $this->table.'.slug',
                $this->table.'.content',
                $this->table.'.cover',
                $this->table.'.created_at',
                $this->table.'.updated_at',
                $this->table.'.vimeo_id',
                $this->table.'.prepared_by',
                $this->table.'.published_by',
                $this->table.'.linkedin'
            )->get()->map(function($row){
                $row->sections = $this->getPostSections($row->id);
                $row->cover = $this->getCover($row->content);
//                if($row->cover)
//                    $row->cover = asset('storage/blog/cover/'.basename($row->cover));
                return $row;
            });
    }

    public function findBySlug(string $slug): Collection
    {
        return DB::table($this->table)->where($this->table.'.slug', $slug)
            ->limit(1)
            ->select(
                DB::raw('('.$this->table.'.id) AS id'),
                $this->table.'.title',
                $this->table.'.content',
                $this->table.'.cover',
                $this->table.'.created_at',
                $this->table.'.updated_at',
                $this->table.'.vimeo_id',
                $this->table.'.prepared_by',
                $this->table.'.published_by',
                $this->table.'.linkedin'
            )->get()->map(function($row){
                $row->sections = $this->getPostSections($row->id);
                $row->cover = $this->getCover($row->content);
//                if($row->cover)
//                    $row->cover = asset('storage/blog/cover/'.basename($row->cover));
                return $row;
            });
    }

    /**
     * store data
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $data = collect($data)->merge([
            'updated_at'    => Carbon::now(),
            'created_at'    => Carbon::now(),
        ]);

        $post_id = DB::table($this->table)->insertGetId($data->toArray());

        $this->doSlug($data['title'], $post_id);

        return $post_id;
    }



    /**
     * check if post is exist
     * @param $post_id
     * @return bool
     */
    public function exists($post_id): bool
    {
        return DB::table($this->table)->where('id', $post_id)->exists();
    }

    /**
     * Update single post data
     * @param int $post_id
     * @param array $data
     */
    public function update(int $post_id, array $data): void
    {
        if(! $this->exists($post_id)){
            $post_id = DB::table($this->table)->insertGetId(collect($data)->merge([
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ])->toArray());

        }else{
            DB::table($this->table)->where('id', $post_id)->update(collect($data)->merge(
                ['updated_at'   => Carbon::now()]
            )->toArray());

        }
        // update Slug
        $this->doSlug($data['title'], $post_id);

    }

    /**
     * Destroy single post
     * @param int $post_id
     */
    public function delete(int $post_id): void
    {
        DB::table($this->table)->where('id', $post_id)->delete();
    }


    public function getCover(string $content): string
    {
        $urls = [];
        preg_match('~<img.*?src=["\']+(.*?)["\']+~', $content, $urls);
        $cover = '';
        if(count($urls) >= 2) {
            $cover = $urls[1];
        }
        return $cover;
    }


    /**
     * @param string $title
     * @param int $post_id
     */
    public function doSlug(string $title, int $post_id): void
    {
        $slug = $this->makeSlug($title, '-');
        $slugExists = DB::table('posts')
            ->where('slug', $slug)
            ->exists();
        if($slugExists){
            $slug = $slug.'-'.$post_id;
            $slugExists = DB::table('posts')->where('slug', $slug)->exists();
            while($slugExists){
                $slug = $slug.'-'.mt_rand(1000, 9999);
            }
        }

        DB::table('posts')->where('id', $post_id)->update(['slug' => $slug]);
    }

    /**
     * @param $str
     * @param string $delimiter
     * @return string
     */
    public function makeSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    /**
     * @param int $post_id
     * @param array $sections
     */
    public function setPostSections(int $post_id, array $sections): void
    {
        DB::table('post_sections')->where('post_id', $post_id)->delete();
        $query = [];
        for($i=0; $i<count($sections); $i++){
            array_push($query, [
                'section_id'    => $sections[$i],
                'post_id'       => $post_id,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
        DB::table('post_sections')->insert($query);
    }

    private function getPostSections(int $post_id): Collection
    {
        $sections = DB::table('post_sections')->where('post_id', $post_id)
            ->join('sections', 'sections.id', '=', 'post_sections.section_id')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcodes WHERE table_=\'sections\' GROUP BY row_) AS transcodes')
                , 'sections.id', '=', 'transcodes.row_')
            ->select([
                'sections.title', 'transcodes.transcode AS title_ar', 'sections.id'
            ])
            ->get();
        return $sections;
    }
}
