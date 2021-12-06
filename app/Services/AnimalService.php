<?php

namespace App\Services;

use App\Models\Animal;

class AnimalService{
    protected function filterAnimals($query, $filters){
        
        if(isset($filters)){
            $filtersArray = explode(',',$filters);
            foreach($filtersArray as $k => $filter){
                list($k,$v) = explode(':',$filter);
                $query->where($k,'like',"%$v%");

            }
        }

        return $query;
        
    }

    protected function sortAnimals($query,$sorts){
        
        if(isset($sorts)){
            $sortsArray = explode(',',$sorts);
            foreach($sortsArray as $k=>$sort){
                list($k,$v) = explode(':',$sort);
                if($v == 'asc' || $v == 'desc'){
                    $query->orderBy($k,$v);
                }
            }
        }else{
            $query->orderBy('id','desc');
        }
        return $query;
    }

    public function getListData($request){

        $limit = $request->limit ?? 10;
        $query = Animal::query()->with('type');
        $query = $this->filterAnimals($query,$request->filters);
        $query = $this->sortAnimals($query,$request->sorts);
        $animals = $query->paginate($limit)->appends($request->query());

        return $animals;
    }


}


?>