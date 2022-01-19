<?php

namespace App\Repositories\Companies;

/**
 * @created doanln  2018-11-08
 */
use App\Repositories\EloquentRepository;
use App\Light\Any;

use App\Repositories\Provinces\ProvinceRepository;
use App\Web\Setting;

class CompanyRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Company::class;
    }
    
    
    public function filter($request){
        // filter
        $orderby = [];
        $sb = strtolower($request->sortby);
        if($sb && in_array($sb, $this->getFields())){
            $orderby[$sb] = $request->sorttype;
            
        }else{
            $orderby['id'] = 'DESC';
        }

        
        $search_by = ['name','email','phone_number'];
        $sb = strtolower($request->searchby);
        if($sb && in_array($sb, $this->getFields())){
            $search_by = $sb;
            
        }
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => $search_by
            ],
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10)
        ];
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

    public function getCompanyOptions()
    {
        $data = ['Chọn nhà xe'];
        if(count($list = $this->get())){
            foreach ($list as $s) {
                $data[$s->id] = $s->name;
                
            }
        }
        return $data;
    }

    public static function getCompanySelectOptions()
    {
        return (new static())->getCompanyOptions();
    }





    public function countRegister($year = null, $month = null)
    {
        if($year){
            $this->whereYear('created_at', $year);
            if($month){
                $this->whereMonth('created_at', $month);
            }
        }
        return $this->count();
    }
}