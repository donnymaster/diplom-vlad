<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ServiceFilterItems{

    private static $SORT_TYPE = [
        'max-star',
        'min-star',
        'old-designer',
        'new-designer'
    ];

    public static function filter($class, $settings){

        if(empty($settings)) { return $class::paginate(9); }

        $array_where = array();

        if(isset($settings['pol-deginer']))
        {
            $array_where = [1];
            
        }
        if(isset($settings['web-designer']))
        {
            $array_where = array_merge($array_where, [2]);
        }

       // dd($array_where);
        if($array_where === array())
        {
            return self::paginate(
                self::sort(
                    $class::get(),
                    $settings['sort'] ?? self::$SORT_TYPE[0]
                ),
                9
            );
        }else
        {
            return self::paginate(
                self::sort(
                    $class::whereIn('design_type_id', $array_where)->get(),
                    $settings['sort'] ?? self::$SORT_TYPE[0]
                ),
                9
            );
        }
        
    }

    private static function sort($items, $sort){
        if(self::sort_check($sort)){
            $new_items = collect([]);
            switch ($sort) {
                case 'max-star':
                    $new_items = $items->SortBy('rating');
                    break;
                case 'min-star':
                    $new_items = $items->SortByDesc('rating');
                    break;
                case 'old-designer':
                    $new_items = $items->SortByDesc('created_at');
                    break;
                case 'new-designer':
                    $new_items = $items->SortBy('created_at');
                    break;
                default:
                    # code...
                    break;
            }
            return $new_items;
        }else{
            return $items;
        }
    }

    private static function sort_check($sort) :bool{

        return in_array($sort, self::$SORT_TYPE);

    }

    public static function get_config($config){

        $new_config = $config;
        if(array_key_exists('page', $config)){
            unset($new_config['page']);
        }if(array_key_exists('sort', $config)){
            unset($new_config['sort']);
        }
        return $new_config;
    }

    private static function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage),
                                        $items->count(),
                                        $perPage,
                                        $page,
                                        $options);
    }
}
