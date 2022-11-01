<?php


namespace App\Repository\Explanation;


use App\Repository\ExplanationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ExplanationRepository implements ExplanationRepositoryInterface
{

    public $table = 'explanations';

    /**
     * return all posts order by created at desc
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function all(array $filters = []): LengthAwarePaginator
    {
        return DB::table($this->table)
            ->where(function($query)use($filters){
                foreach($filters as $key_filter => $value_filter){
                    if($key_filter == 'word'){
                        if($value_filter){
                            $query->where($this->table.'.title', 'LIKE', '%'.$value_filter.'%')
                                ->orWhere($this->table.'.explanation', 'LIKE', '%'.$value_filter.'%');
                        }
                    }else{
                        $query->where($this->table.'.'.$key_filter, $value_filter);
                    }
                }
            })
            ->orderBy($this->table.'.created_at', 'desc')
            ->leftJoin('courses', $this->table.'.course_id', '=', 'courses.id')
            ->leftJoin('chapters', $this->table.'.chapter_id', '=', 'chapters.id')
            ->select(
                DB::raw('('.$this->table.'.id) AS id'),
                $this->table.'.course_id',
                $this->table.'.chapter_id',
                $this->table.'.title',
                $this->table.'.explanation',
                DB::raw('(courses.title) AS course_title'),
                DB::raw('(chapters.name) AS chapter_title'),
                $this->table.'.created_at',
                $this->table.'.updated_at'
            )->paginate(20);
    }

    /**
     * return single post full data
     * @param int $post_id
     * @return Collection
     */
    public function find(int $post_id): Collection
    {
        return DB::table($this->table)->where($this->table.'.id', $post_id)
            ->leftJoin('courses', $this->table.'.course_id', '=', 'courses.id')
            ->leftJoin('chapters', $this->table.'.chapter_id', '=', 'chapters.id')
            ->select(
                DB::raw('('.$this->table.'.id) AS id'),
                $this->table.'.course_id',
                $this->table.'.chapter_id',
                $this->table.'.title',
                $this->table.'.explanation',
                DB::raw('(courses.title) AS course_title'),
                DB::raw('(chapters.name) AS chapter_title'),
                $this->table.'.created_at',
                $this->table.'.updated_at'
            )->get();
    }

    /**
     * store data
     * @param array $data
     * @return bool
     */
    public function save(array $data): int
    {
        $data = collect($data)->merge([
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
        return DB::table($this->table)->insertGetId($data->toArray());
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
            DB::table($this->table)->insertGetId(collect($data)->merge([
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ])->toArray());
        }else{
            DB::table($this->table)->where('id', $post_id)->update(collect($data)->merge(
                ['updated_at'   => Carbon::now()]
            )->toArray());
        }

    }

    /**
     * Destroy single post
     * @param int $post_id
     */
    public function delete(int $post_id): void
    {
        DB::table($this->table)->where('id', $post_id)->delete();
    }



}
