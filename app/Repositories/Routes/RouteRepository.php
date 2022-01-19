<?php

namespace App\Repositories\Routes;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

class RouteRepository extends EloquentRepository
{
    

    protected $where_args = [
        '@actions' => [
            ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
            ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],
            ['leftJoin', 'provinces as from_provinces', 'from_provinces.id', '=', 'start_stations.province_id'],
            ['leftJoin', 'provinces as to_provinces', 'to_provinces.id', '=', 'end_stations.province_id'],
            
        ],
        '@selectRaw' => 'routes.*, start_stations.name as start_station, end_stations.name as end_station, from_provinces.name as from_province, to_provinces.name as to_province'
    ];

    protected $search_orderby_list = [
        'start_station'     => 'start_stations.name',
        'end_station'       => 'end_stations.name',
        'from_province'     => 'from_provinces.name',
        'to_province'       => 'to_provinces.name'
        
    ];
    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Route::class;
    }
    
    public function filter($request, $args = [])
    {
        $orderby = [];
        $sb = strtolower($request->sortby);
        if(($sb && in_array($sb, $this->getFields())) || isset($this->search_orderby_list[$sb])){
            if(isset($this->search_orderby_list[$sb])) $sb = $this->search_orderby_list[$sb];
            $orderby[$sb] = $request->sorttype;
            
        }else{
            $orderby['id'] = 'DESC';
        }

        
        $search_by = ['name'];
        $sb = strtolower($request->searchby);
        if(($sb && in_array($sb, $this->getFields())) || isset($this->search_orderby_list[$sb])){
            if(isset($this->search_orderby_list[$sb])) $sb = $this->search_orderby_list[$sb];
            $search_by = $sb;
            
        }

        $where_args = $this->where_args;
        $args = array_merge($where_args, [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => $search_by
            ],
            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10),

        ]);
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

    public function detail($id)
    {
        $args = $this->where_args;
        $args['id'] = $id;
        $route = $this->first($args);
        if($route){
            //
        }
        return $route;
    }


    public function getRouteSelectOptions($type=1)
    {
        $where_args = $this->where_args;

        $sol = $this->search_orderby_list;
        $where = [];
        // if(is_array($args) && count($args)){
        //     foreach ($args as $key => $value) {
        //         $k = strtolower($key);
        //         if(in_array($k, $sol)){
        //             $where[$k] = $value;
        //         }elseif (isset($sol[$k])) {
        //             $where[$sol[$k]] = $value;
        //         }
        //     }
        // }

        if($type==2){
            $data = ['Chọn tuyến buýt'];
            $where['type'] = 'bus';
        }else{
            $data = ['Chọn tuyến xe'];
            $where['type'] = ['direct', 'indirect'];
        }

        $args = array_merge($where_args, $where);
        
        if(count($list = $this->get($args))){
            foreach ($list as $p) {
                $data[$p->id] = $p->id.' - '.$p->name . ' ('.$p->start_station . ' - '. $p->end_station . ' )';
                
            }
        }
        return $data;
    }

    public static function getRouteOptions($type=1)
    {
        return (new static())->getRouteSelectOptions($type);
    }


    
    public function countOpened($year = null, $month = null)
    {
        if($year){
            $this->whereYear('created_at', $year);
            if($month){
                $this->whereMonth('created_at', $month);
            }
        }
        return $this->count();
    }

    public function coumtTripsRegisterOfBus($id, $notBusID=null)
    {
        $n = null;
        if($route = $this->find($id)){
            $n = $route->coumtTripsRegisterOfBus($notBusID);
        }
        return $n;
    }
}