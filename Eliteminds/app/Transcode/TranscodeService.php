<?php


namespace App\Transcode;


use App\Localization\Locale;
use Illuminate\Support\Facades\Cache;

class TranscodeService
{
    /**
     * @param string $lang
     * @return string
     */
    public function TranscodeClass($lang = 'ar'){
        switch($lang){
            case 'en':
                return null;
            case 'ar':
                return \App\Transcode::class;
            case 'fr':
                return \App\TranscodeFr::class;
        }
        return \App\Transcode::class;
    }

    /**
     * @param string $lang
     * @return string|null
     */
    public function TranscodeModel($lang = 'ar'){
        switch($lang){
            case 'en':
                return null;
            case 'ar':
                return new \App\Transcode;
            case 'fr':
                return new \App\TranscodeFr;
        }
        return new \App\Transcode;
    }

    /**
     * @param null $lang
     * @return string|null
     */
    public function getTranslationTable($lang = null){
        if(!$lang){
            $locale = new Locale;
            $lang = $locale->locale;
        }
        switch($lang){
            case 'fr':
                return 'transcode_frs';
            case 'ar':
                return 'transcodes';
            default:
                return null;
        }
    }


    /**
     * Support Ar, Fr
     * @param $row
     * @param $values_arr
     * @param $lang
     */
    public function update($row, $values_arr, $lang = 'ar'){

        $table = $row->table;
        $columns = $row->transcodeColumns;
        $row_id = $row->id;
        Cache::forget($lang.'_'.$table.'_'.$row_id);
        foreach($columns as $col){
            if($values_arr[$col]) {
                $tc = $this->TranscodeClass($lang)::where('table_', $table)->where('row_', $row_id)->where('column_', $col)->first();
                if($tc){
                    $tc->transcode = $values_arr[$col];
                    $tc->save();
                }else{
                    $tc = $this->TranscodeModel($lang);
                    $tc->table_ = $table;
                    $tc->column_ = $col;
                    $tc->row_ = $row_id;
                    $tc->transcode = $values_arr[$col];
                    $tc->save();
                }
            }
        }

    }


    /**
     * @param $row
     * @param int $forceToGet
     * @param bool $empty_fallback
     * @return array
     */
    public function evaluate($row, $forceToGet = 0, $empty_fallback = false){

        $locale = new Locale;
        try{
            $table = $row->table;
            $columns = $row->transcodeColumns;
            $row_id = $row->id;    
        }catch(\Exception $e){
            return [];
        }

        $forceToGet = $forceToGet === true? 1: $forceToGet;
        $cache_Key_lang = $forceToGet? ($forceToGet === 1? 'ar': $forceToGet): $locale->locale;
        // Cache::forget($cache_Key_lang.'_'.$table.'_'.$row_id);
        $transCodes = Cache::remember($cache_Key_lang.'_'.$table.'_'.$row_id, 1440, function()use($table, $row_id, $locale, $forceToGet){
            $translationClass = $this->TranscodeClass($locale->locale);
            if($forceToGet){
                if(in_array($forceToGet, ['ar', 'en', 'fr'])){
                    $translationClass = $this->TranscodeClass($forceToGet);
                }else{
                    /** TO give backward compatibility */
                    /** @var  $translationClass */
                    $translationClass = $this->TranscodeClass('ar');
                }
            }
            /** If 'en' return null  */
            return $translationClass ? $translationClass::where('table_', $table)->where('row_', $row_id)->get(): null;
        });

        if($forceToGet || $locale->locale != 'en'){
            return ($this->getModelTranslation($transCodes, $columns, $row, $empty_fallback));
        }

        if($locale->locale == 'en'){
            $obj = [];
            foreach($columns as $col){
                if($row[$col]){
                    $obj[$col] = $row[$col];
                }else{
                    /** no fallback, return empty */
                    $obj[$col] = '';
                }
            }
            return $obj;
        }

        return [];
    }

    public function getModelTranslation($transCodes, $columns, $row = null, $empty_fallback = false){
        $obj = [];
        foreach($columns as $col){
            if($transCodes){
                $t = $transCodes->first(function ($i) use($col){
                    return $i->column_ == $col;
                });
                if($t){
                    $obj[$col] = $t->transcode;
                }else{
                    /** Fallback to English if $row is not Null */
                    $obj[$col] = '';
                    if(!$empty_fallback){
                        if($row){
                            if($row[$col]){
                                $obj[$col] = $row[$col];
                            }
                        }
                    }

                }
            }else{
                $obj[$col] = '';
                if(!$empty_fallback) {
                    if ($row) {
                        if ($row[$col]) {
                            $obj[$col] = $row[$col];
                        }
                    }
                }
            }

        }
        return $obj;
    }


    /**
     * Support Ar, Fr
     * @param $row
     * @param $values_arr
     * @param string $lang
     */
    public function add($row, $values_arr, $lang = 'ar'){
        $table = $row->table;
        $columns = $row->transcodeColumns;
        $row_id = $row->id;

        foreach($columns as $col){
            if($values_arr[$col] != ''){
                $tc = $this->TranscodeModel($lang);
                $tc->table_ = $table;
                $tc->column_ = $col;
                $tc->row_ = $row_id;
                $tc->transcode = $values_arr[$col];
                $tc->save();
            }
        }

    }

    /**
     * Support Ar, Fr
     * @param $row
     * @param string $lang
     */
    public function delete($row, $lang = 'ar'){
        $table = $row->table;
        $columns = $row->transcodeColumns;
        $row_id = $row->id;
        $this->TranscodeClass($lang)::where('table_', $table)->where('row_', $row_id)->delete();
    }




}
