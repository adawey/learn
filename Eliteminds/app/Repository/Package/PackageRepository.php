<?php


namespace App\Repository\Package;


use App\Payment\Payment;
use App\Repository\PackageRepositoryInterface;
use App\Transcode\Transcode;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PackageRepository implements PackageRepositoryInterface
{

    /** Payment Services */
    use Payment;

    public function getPackagesByCourse(int $course_id, string $country_code, string $lang): Collection
    {
        /** Get translation table name */
        $translationTable = Transcode::getTranslationTable($lang);

        /** Forget Cache if it required */
        Cache::forget('coursePackagesCache-'.$country_code.'-'.$lang);
        /** return cached collection */
        return (Cache::remember('coursePackagesCache-'.$country_code.'-'.$lang, 1440, function()use($translationTable, $course_id){
            return $this->generatePackageDetails($course_id, false, $translationTable);
        }));
    }

    public function getPopularPackages(string $country_code, string $lang): Collection
    {
        /** Get translation table name */
        $translationTable = Transcode::getTranslationTable($lang);

        /** Forget Cache if it required */
        Cache::forget('popularPackagesCache-'.$country_code.'-'.$lang);
        /** return cached collection */
        return (Cache::remember('popularPackagesCache-'.$country_code.'-'.$lang, 1440, function()use($translationTable){
            return $this->generatePackageDetails(null, true, $translationTable);
        }));
    }

    public function generatePackageDetails(int $course_id = null, bool $popular = false, $translationTable): Collection{
        $packages = DB::table('packages')
            ->where([
                'active'    => 1,
            ])
            ->where(function($query)use($popular, $course_id){
                if($popular){
                    $query->where('popular', 1);
                }
                if($course_id){
                    $query->where('course_id', $course_id);
                }
            })
            ->leftJoin('ratings', 'packages.id', '=', 'ratings.package_id')
            ->join('courses', 'packages.course_id', '=', 'courses.id')->orderBy('updated_at','desc')->limit(6);

        if($translationTable){
            $packages = $packages->leftJoin(DB::raw('(SELECT '.$translationTable.'.column_, '.$translationTable.'.transcode, '.$translationTable.'.row_ FROM '.$translationTable.' WHERE table_ = \'courses\') AS course_transcodes'), function($join){
                $join->on('course_transcodes.row_', '=', 'courses.id');
            })
                ->leftJoin(DB::raw('(SELECT '.$translationTable.'.column_, '.$translationTable.'.transcode, '.$translationTable.'.row_ FROM '.$translationTable.' WHERE table_ = \'packages\') AS package_title_transcodes'), function($join){
                    $join->on('package_title_transcodes.row_', '=', 'packages.id');
                })
                ->select(
                    DB::raw('SUM((CASE WHEN ratings.id IS NOT NULL THEN 1 ELSE 0 END)) AS rating_count'),
                    DB::raw('AVG((CASE WHEN ratings.rate IS NOT NULL THEN ratings.rate ELSE 0 END)) AS rate'),
                    DB::raw('(CASE WHEN course_transcodes.transcode IS NULL THEN packages.name ELSE course_transcodes.transcode END) AS course_title'),
                    'packages.*',
                    DB::raw('(CASE WHEN package_title_transcodes.transcode IS NULL THEN packages.name ELSE package_title_transcodes.transcode END) AS name')
                );
        }else{
            $packages = $packages->select(
                DB::raw('SUM((CASE WHEN ratings.id IS NOT NULL THEN 1 ELSE 0 END)) AS rating_count'),
                DB::raw('AVG((CASE WHEN ratings.rate IS NOT NULL THEN ratings.rate ELSE 0 END)) AS rate'),
                DB::raw('courses.title AS course_title'),
                'packages.*'
            );
        }

        return ($packages->groupBy('packages.id')->get()->map(function($item){
            return (object)[
                'package'               => $item,
                'enrolled_student_no'   => $this->enrolledStudentCount($item->id),
                'pricing'               => $this->getPackagePriceDetails($item->id),
                'lessons_number'        => $this->getLessonsNumber(explode(',', $item->chapter_included ?? '')),
            ];
        })->sortByDesc('enrolled_student_no'));
    }



    public function enrolledStudentCount(int $package_id): int
    {
        return DB::table('user_packages')
            ->where('package_id', $package_id)
            ->select(DB::raw('(COUNT(*)) AS enrolled_no'))
            ->get()->first()->enrolled_no;
    }

    public function getPackagePriceDetails(int $package_id): Collection
    {
        return collect($this->PriceDetails('', $package_id, 'package'));
    }

    public function getLessonsNumber(array $chapters_arr = []): int
    {
        return Cache::remember(implode( '-',$chapters_arr), 1440, function()use($chapters_arr){
            return DB::table('videos')->whereIn('chapter', $chapters_arr)->count();
        });
    }
}
