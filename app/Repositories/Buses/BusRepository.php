<?php

namespace App\Repositories\Buses;

/**
 * @created doanln  2018-11-18
 */
use App\Repositories\EloquentRepository;
use App\Light\Any;

use App\Repositories\Provinces\ProvinceRepository;
use App\Web\Setting;

class BusRepository extends EloquentRepository
{
    protected $where_args = [
        '@actions' => [
            ['leftJoin', 'routes', 'routes.id', '=', 'buses.route_id'],
            ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
            ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],
            ['leftJoin', 'provinces as from_provinces', 'from_provinces.id', '=', 'start_stations.province_id'],
            ['leftJoin', 'provinces as to_provinces', 'to_provinces.id', '=', 'end_stations.province_id'],
            ['leftJoin', 'companies', 'companies.id', '=', 'buses.company_id']
            
        ],
        '@select' => [
            'buses.*',
            'routes.name as route', 'start_stations.name as start_station', 'end_stations.name as end_station', 
            'from_provinces.name as from_province', 'to_provinces.name as to_province',
            'companies.name as company'
        ]
    ];

    protected $search_filter_by = [
        'route' => 'routes.name',
        'start_station' => 'start_stations.name',
        'end_station' => 'end_stations.name',
        'from_province' => 'from_provinces.name',
        'to_province' => 'to_provinces.name',
        'company' => 'companies.name'
    ];
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Bus::class;
    }
    
    
    public function filter($request){
        // filter
        $orderby = [];
        $sb = strtolower($request->sortby);
        if($sb && (in_array($sb, $this->getFields()) || in_array($sb, $this->search_filter_by) || isset($this->search_filter_by[$sb]))){
            if(isset($this->search_filter_by[$sb])){
                $sb = $this->search_filter_by[$sb];
            }
            $orderby[$sb] = $request->sorttype;
            
        }else{
            $orderby['id'] = 'DESC';
        }

        
        $search_by = ['license_plate','company_id','phone_number'];
        $sb = strtolower($request->searchby);
        if($sb && (in_array($sb, $this->getFields()) || in_array($sb, $this->search_filter_by) || isset($this->search_filter_by[$sb]))){
            if(isset($this->search_filter_by[$sb])){
                $search_by = $this->search_filter_by[$sb];
            }else{
                $search_by = $sb;
            }
            
            
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

        $fields = $request->all();
        if($fields){
            foreach ($fields as $key => $value) {
                if(in_array($k = strtolower($key), $this->getFields())){
                    $args[$k] = $value;
                }
            }
        }
        $args = array_merge($this->where_args, $args);
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

    public function getBusOptions($company_id=null)
    {
        $args = [
            '@where' => ['company_id', '>', 0]
        ];
        if($company_id){
            $args['company_id'] = $company_id;
        }
        $data = ['Chọn nhà xe'];
        if(count($list = $this->get($args))){
            foreach ($list as $p) {
                $data[$p->id] = $p->name;
                
            }
        }
        return $data;
    }

    public static function getBusSelectOptions($company_id=null)
    {
        return (new static())->getBusOptions($company_id);
    }

    public static function getFreqDays()
    {
        $data = [];
        $l = ' ngày';
        $numbers = [1, 2, 4, 6, 8, 10];
        foreach($numbers as $d){
            $data[$d] = $d.$l;
        }
        return $data;
    }

    public static function getFreqtrips($days = 1)
    {
        if($days>1) return [1=>'1 chuyến'];
        $data = [];
        $l = ' chuyến';
        for($d = 1; $d < 11; $d++){
            $data[$d] = $d.$l;
        }
        return $data;
    }

    public function getFreqtripOptions($days = 1)
    {
        return self::getFreqtrips($days);
    }


    public static function getOptions()
    {
        $data = ["chọn xe"];
    }


    public function countBusActive($year = null, $month = null)
    {
        $args = [
            'trips.status' => 100,
            'buses.is_active' => 1,
            '@actions' => [
                ['join', 'schedules', 'schedules.bus_id', '=', 'buses.id'],
                ['join', 'trips', 'trips.schedule_id', '=', 'schedules.id']
            ],
            '@groupBy' => ['buses.id']
        ];
        if($year){
            $this->whereYear('trips.started_at', $year);
            if($month){
                $this->whereMonth('trips.started_at', $month);
            }
        }
        return $this->count($args);
    }

    public function countBusRegister($year = null, $month = null)
    {
        $this->is_active = 1;
        if($year){
            $this->whereYear('created_at', $year);
            if($month){
                $this->whereMonth('created_at', $month);
            }
        }
        return $this->count();
    }
}