<?php

namespace App\Repositories\Trips;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Light\Any;

use Carbon\Carbon;

use DB;

class TripRepository extends EloquentRepository
{
    protected $_query_args = [
        '@actions' => [
            ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
            ['join', 'buses','buses.id','=','schedules.bus_id'],
            ['join', 'companies','buses.company_id','=','companies.id'],
            ['join','routes','routes.id','=','schedules.route_id'],
            ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
            ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],
        ],
        '@select' => [
            'trips.*', 'schedules.direction', 'routes.name as route_name', 'routes.type as route_type',
            'routes.from_id', 'routes.to_id',
            'start_stations.name as from_station', 
            'end_stations.name as to_station','buses.license_plate_clean as license_clean',
            'buses.license_plate','companies.name as company_name', 'companies.phone_number as company_phone_numeber',
            'companies.email as company_email', 'buses.phone_number as bus_phone_number'
        ],
        '@selectRaw' => 'YEAR(trips.completed_at) as year, MONTH(trips.completed_at) as month, DAY(trips.completed_at) as day, HOUR(trips.completed_at) as hour, MINUTE(trips.completed_at) as minute, SECOND(trips.completed_at) as swcond'
    ];
    
    protected $_search_by = [
        'to_station' => 'end_stations.id',
        'company_id' => 'companies.id'
    ];
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Trip::class;
    }
    
    public function getTimes($args = [])
    {
        $unique = [];
        $times = [];
        $this->oederBy('started_at','ASC');
        if(count($list = $this->get($args))){
            foreach ($list as $trip) {
                $time = [];
                $started_time = strtotime($trip->started_at);
                $t = date('H:i:s', $started_time);
                if(!in_array($t, $unique)){
                    $unique[] = $t;
                    $form = [
                        'started' => get_datetime_array($trip->started_at),
                        'arrived' => get_datetime_array($trip->arrived_at),
                        'estimated_time' => $trip->estimated_time,
                        'estimated_time_array' => $trip->getEstimateTimeArray()
                    ];
                    if($form['started']['hour']){
                        $form['old_started'] = $form['started']['hour'].':'.$form['started']['minute'];
                    }
                    if($form['arrived']['hour']){
                        $form['old_arrived'] = $form['arrived']['hour'].':'.$form['arrived']['minute'];
                    }
            
                    $times[] = $form;
                }
            }
        }
        // dd($times);
        return $times;
    }
    public function getFormData($id)
    {
        $args = array_merge([
            '@actions' => [
                ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
                ['join', 'buses','buses.id','=','schedules.bus_id'],
                ['join','routes','routes.id','=','schedules.route_id'],
                ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
                ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],
            ],
            '@select' => [
                'trips.*', 'schedules.direction', 'routes.name as route_name', 'routes.type as route_type', 
                'routes.from_id', 'routes.to_id', 'start_stations.name as from_station', 'end_stations.name as to_station',
                'buses.license_plate'
            ]
        ],['id'=> $id]);
        if (!$trip = $this->first($args)) {
            return null;
        }
        $trip->estimated = get_time_array($trip->estimated_time);
        $trip->started = get_datetime_array($trip->started_at);
        $trip->arrived = get_datetime_array($trip->arrived_at);
        return $trip;
        
    }


    public function saveTrip($data)
    {
        $id = $data['id'];
        
        $trip = $this->find($id);
        $schedule = $trip->schedule;
        $route = $schedule->route;
        $dataSave = [];
        

        $started = new Any(isset($data['started'])?$data['started']:[]);
        $started_at = "$started->year-$started->month-$started->day $started->hour:$started->minute:00";
        
        if (in_array($route->type, ['direct','bus']) && in_array(get_station_id(), [$route->from_id, $route->to_id])){
            $estimated = new Any(isset($data['estimated'])?$data['estimated']:[]);

            $estimated_time = $estimated->day(0)*3600*24 
            + $estimated->hour(0)*3600 
            + $estimated->minute(0)*60 
            + $estimated->second(0);
            $arrived_at = date('Y-m-d H:i:s', strtotime($started_at) + $estimated_time);

        }else{
            $arrived = new Any(isset($data['arrived'])?$data['arrived']:[]);
            $arrived_at = "$arrived->year-$started->month-$started->day $started->hour:$started->minute:00";
            $estimated_time = abs(strtotime($arrived_at) - strtotime($started_at));
        }

        


        
        $updateData = compact('estimated_time', 'started_at', 'arrived_at');
        if($schedule->direction){
            $updateData['completed_at'] = ($schedule->direction == 1)?$started_at:$arrived_at;
        }
        if(isset($data['status']) && in_array($data['status'], [0,1,-1])){
            $updateData['status'] = $data['status'];
        }
        $tripSaved = $this->save($updateData,$id);

        return $tripSaved;

    }

    public function saveTrips($schedules, $trip_data, $direction=0)
    {
        $saved = [];
        $dataSave = [];
        $status = true;

        if(count($schedules) && count($trip_data)){
            $route = null;
            $time_between = 0;
            $time_start = 0;
            $time_end = 86399;
            foreach($schedules as $schedule){
                if(!$route) {
                    $route = $schedule->route;
                    $time_between = get_time_seconds($route->time_between);
                    $time_start = get_time_seconds($route->time_start);
                    $time_end = get_time_seconds($route->time_end);
                    

                }

                if($route->type == 'direct' || ($route->type=='bus' && in_array(get_station_id(), [$route->from_id, $route->to_id]))){
                    $scheduleTrips = [];
                    $last_time = 0;
                    
                    foreach ($trip_data as $data) {
                        $trip = new Any($data);
                        $old_start = $schedule->active_date.' '.$trip->old_started.':00';
                        $this->schedule_id = $schedule->id;
                        $this->started_at = $old_start;
                        $id = null;
                        if($m = $this->first()){
                            $id = $m->id;
                        }


                        $estimated_time = $trip->et_day(0)*3600*24 
                                        + $trip->et_hour(0)*3600 
                                        + $trip->et_minute(0)*60 
                                        + $trip->et_second(0);
    
                        $started_at = $schedule->active_date.' '.$trip->st_hour('00').':'.$trip->st_minute('00').':'.'00';
                        // echo "$started_at == $old_start <br>";
                        if($started_at == $old_start){

                            $saved[] = $id;
                        }else{
                            
                            $arrived_at = date('Y-m-d H:i:s', strtotime($started_at) + $estimated_time);
                            $schedule_id = $schedule->id;

                            $start_time = strtotime($started_at);
                            if($last_time){
                                if($start_time-$last_time < $time_between){
                                    $status = false;
                                }
                            }
                            
                            $last_time = $start_time;
                            $before_time = $start_time-$time_between;
                            $after_time = $start_time+$time_between;
    
                            $st_time = get_time_seconds($trip->st_hour('00').':'.$trip->st_minute('00').':'.'00');
                            if($st_time < $time_start || $st_time > $time_end){
                                $status = false;
                            }
                            if($t = count($list_trip = $this->getBetweenDate($schedule->active_date, date('H:i:s', $before_time), date('H:i:s', $after_time), $route->id, $direction, $id)))
                            {
                                if(!$id) $status = false;
                                else{
                                    foreach ($list_trip as $item) {
                                        if($item->id != $id) $status = false;
                                    }
                                }
                            }

                            $data = compact('schedule_id', 'estimated_time', 'started_at', 'arrived_at');
    
                            if($direction){
                                $data['completed_at'] = ($direction == 1)?$started_at:$arrived_at;
                                
                            }
                            $dataSave[] = [
                                'data' => $data,
                                'id' => $id
                            ];
                            if($id){
                                $saved[] = $id;
                            }
                        }
                        

                    }
                    if(count($schedule->trips)){
                        foreach ($schedule->trips as $st) {
                            if(!in_array($st->id, $saved)){
                                $st->delete();
                            }
                        }
                    }
                }
                else{
                    $scheduleTrips = [];
                    foreach ($trip_data as $data) {
                        $trip = new Any($data);
                        $schedule_id = $schedule->id;
                        $this->schedule_id = $schedule_id;
                        $this->arrived_at = $schedule->active_date.' '.$trip->old_arrived.':00';
                        $id = null;
                        if($m = $this->first()){
                            $id = $m->id;
                        }
                        $started_at = $schedule->active_date.' '
                                        .$trip->st_hour('00').':'
                                        .$trip->st_minute('00').':'
                                        .'00';
                        $arrived_at = $schedule->active_date.' '
                                        .$trip->ar_hour('00').':'
                                        .$trip->ar_minute('00').':'
                                        .'00';
                        $estimated_time = strtotime($arrived_at) - strtotime($started_at);
                        
    
                        $data = compact('schedule_id', 'estimated_time', 'started_at', 'arrived_at');
                        if($direction){
                            $data['completed_at'] = $started_at;
                            
                        }
                        $dataSave[] = [
                            'data' => $data,
                            'id' => $id
                        ];
                        if($id){
                            $saved[] = $id;
                        }

                    }
                    if(count($schedule->trips)){
                        foreach ($schedule->trips as $st) {
                            if(!in_array($st->id, $saved)){
                                $st->delete();
                            }
                        }
                    }
                }
                
            }
            if($status && count($dataSave)){
                foreach ($dataSave as $item) {
                    $this->save($item['data'], $item['id']);
                }
            }
        }
        return $status;
    }


    public function getBetweenDate($date, $from,$to,$routeID,$direction=1, $notID=0)
    {
        $args = [
            '@actions' => [
                ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
                ['join', 'buses','buses.id','=','schedules.bus_id'],
                ['join','routes','routes.id','=','schedules.route_id'],
                ['whereDate', 'trips.started_at', $date],
                ['whereTime', 'trips.started_at', '>', $from],
                ['whereTime', 'trips.started_at', '<', $to],
                ['where', 'routes.id', $routeID],
                ['where', 'schedules.direction', $direction]
            ],
            '@select' => [
                'trips.*', 'schedules.direction', 'routes.name as route_name', 'routes.type as route_type', 
                'routes.from_id', 'routes.to_id', 'buses.license_plate'
            ]
        ];
        if($notID){
            $args['@actions'][] = ['where', 'buses.id','!=', $notID];
        }
        // dd($this->query($args)->toSql());
        return $this->get($args);
    }


    public function deleteTheSame($notID,$schedule_id, $started_at)
    {
        $args = [
            'schedules.id' => $schedule_id,
            'trips.started_at' => $started_at,
            '@actions' => [
                ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
                ['join', 'buses','buses.id','=','schedules.bus_id'],
                ['join','routes','routes.id','=','schedules.route_id'],
                ['where', 'buses.id','!=', $notID]
            ],
            '@select' => ['trips.id']
        ];

        if(count($list = $this->get($args))){
            foreach ($list as $item) {
                $item->delete();
            }
        }
    }

    public function filter($request, $args = [], $user_type = 0)
    {

        $args = $this->getFilterArgs($request, $args);

        $dates = explode('-',date('Y-m-d'));
        $time = time();
        $y = $dates[0];
        $m = $dates[1];
        $d = $dates[2];
        $ry = $request->year; 
        $rm = $request->month; 
        $rd = $request->day;
        if($request->date){
            $date = $request->date;
            $k = null;
            $l = 0;
            if(preg_match('/\d{1,2}\/\d{1,2}\/\d{4}/i', $date)){
                $k = '/';
            }elseif(preg_match('/\d{1,2}\-\d{1,2}\-\d{4}/i', $date)){
                $k = '-';
            }elseif(preg_match('/\d{4}\-\d{1,2}\-\d{1,2}/i', $date)){
                $k = '-';
                $l = 1;
            }
            
            if($k){
                $dd = explode($k, $date);
                if($l == 1){
                    if(is_date($dd[2], $dd[1], $dd[0])){
                        $ry = $dd[0]; 
                        $rm = $dd[1]; 
                        $rd = $dd[2];
                    }
                }elseif(is_date($dd[0], $dd[1], $dd[2])){
                    $ry = $dd[2]; 
                    $rm = $dd[1]; 
                    $rd = $dd[0];
                }
            }

            
        }
        
        $wy = null;
        $wm = null;
        $wd = null;

        if(!$ry){
            $wy = $y;
        }else{
            $wy = $ry;
        }
        if(!$rm && $wy == $y){
            $wm = $m;
        }elseif($rm){
            $wm = $rm;
        }
        if($rd && $wm && $wm !='all'){
            $wd = $rd;
        }elseif ($wy == $y && $wm == $m) {
            $wd = $d;
        }
        
        $from_id = null;
        $to_id = null;
        if($wy && !in_array(strtolower($wy), ['*','all'])){
            $this->whereYear('trips.completed_at', $wy);
        }

        if($wm && !in_array(strtolower($wm), ['*','all'])){
            $this->whereMonth('trips.completed_at', $wm);
        }

        if($wd && !in_array(strtolower($wd), ['*','all'])){
            $this->whereDay('trips.completed_at', $wd);
        }
        if($user_type){
            // eo biết làm gì luôn
        }else{
            // $this->where('completed_at', '>=', date('Y-m-d H:i:s'));
            $station_id = get_station_id();
            $from_id = $request->from?$request->from:$station_id;

            $to_id = $request->to;
            $this->where(function($qr) use($from_id, $to_id){
                $qr->where(function($query) use($from_id, $to_id){
                    $query->where('routes.from_id', $from_id)
                         ->where('routes.to_id', $to_id)
                         ->where('schedules.direction', 1);
                })->orWhere(function($query) use($from_id, $to_id){
                    $query->where('routes.from_id', $to_id)
                         ->where('routes.to_id', $from_id)
                         ->where('schedules.direction', 2);
                });
            });
            $this->where('trips.status', '>=', 0);
            $this->where('trips.status', '<', 100);

            $args['@actions'][] = ['leftJoin', 'ticket_prices', function($join){
                $join->on('ticket_prices.company_id', '=', 'companies.id');
                $join->on('ticket_prices.route_id', '=', 'routes.id');
            }];
            $args['@select'][] = 'ticket_prices.price as ticket_price';
            // $this->where('date.open', 1);
            // $this->whereDate('completed_at'. '<', date('Y-m-d',$time+3600*24*7));
            // dd($args);
            
        }
        // $this->groupBy('trips.id');



        // dd($this->_params);
        
        // dd($this->query());
        $list = $this->get($args);
        // dd($list);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return [
            'list' => $list,
            'day'  => $wd,
            'month'=> $wm,
            'year' => $wy,
            'from' => $from_id,
            'to' => $to_id
        ];
    }


    public function getFilterArgs($request, $args = [])
    {
        // filter
        $orderby = [];
        $sb = strtolower($request->sortby);
        if($sb && (in_array($sb, $this->getFields()) || in_array($sb, $this->_search_by) || isset($this->_search_by[$sb]))){
            if(isset($this->_search_by[$sb])){
                $sb = $this->_search_by[$sb];
            }
            $orderby[$sb] = $request->sorttype;
            
        }else{
            $orderby['completed_at'] = 'ASC';
        }

        $search_by = ['buses.license_plate'];
        $sb = strtolower($request->searchby);
        if($sb && (in_array($sb, $this->getFields()) || in_array($sb, $this->_search_by) || isset($this->_search_by[$sb]))){
            if(isset($this->_search_by[$sb])){
                $search_by = $this->_search_by[$sb];
            }else{
                $search_by = $sb;
            }
            
            
        }
        $args = array_merge(
            array_merge($this->_query_args, [
                // search
                '@search' => [
                    'keyword' => $request->s,
                    'by' => $search_by
                ],
                '@order_by' => $orderby,
                '@paginate' => ($request->perpage ? $request->perpage : 20),
                
            ]), $args
        );

        $fields = $request->all();
        if($fields){
            foreach ($fields as $key => $value) {
                $k = $k = strtolower($key);
                if(in_array($k, $this->getFields())){
                    $args[$k] = $value;
                }elseif(in_array($k, $this->_search_by)){
                    $args[$k] = $value;
                }elseif(isset($this->_search_by[$k])){
                    $args[$this->_search_by[$k]] = $value;
                }
            }
        }
        return $args;
    }



    public function detail($request, $args = [])
    {
        // filter
        $args = array_merge($this->_query_args, $args);

        $fields = $request->all();
        if($fields){
            foreach ($fields as $key => $value) {
                $k = $k = strtolower($key);
                if(in_array($k, $this->getFields())){
                    $args[$k] = $value;
                }elseif(in_array($k, $this->_search_by)){
                    $args[$k] = $value;
                }elseif(isset($this->_search_by[$k])){
                    $args[$this->_search_by[$k]] = $value;
                }
            }
        }

        $args['@actions'][] = ['leftJoin', 'ticket_prices', function($join){
            $join->on('ticket_prices.company_id', '=', 'companies.id');
            $join->on('ticket_prices.route_id', '=', 'routes.id');
        }];
        $args['@select'][] = 'ticket_prices.price as ticket_price';
        $this->groupBy('trips.id');




        return $this->first($args);
    }

    /**
     * Tìm chuyến
     * @param int $bus_id
     * @param int $direction
     * @param string $action
     * @param string $date
     * @param int $status
     */
    public function search($bus_id = 0, $direction = 0, $action = null, $date = null, $status = null)
    {
        if($bus_id) $this->where('buses.id', $bus_id);
        if($direction) $this->where('schedules.direction', $direction);
        if($action && $date){
            $this->whereDate($action.'_at', $date);
        }
        if(!is_null($status)) $this->status = $status;
        $this->orderBy('completed_at', 'ASC');
        return $this->get($this->_query_args);
        
    }

    public function addLog($id, $status, $action=0, $tickets = null)
    {
        $data = ['status'=>$status];
        
        if($status!=-1){
            $key = 'checkin_at';
            if(in_array($action, [1,3])){
                $key = 'checkout_at';
            }
            $data[$key] = date('Y-m-d H:i:s');
            $data['completed_at'] = $data[$key];
            if($status == 100 && $tickets){
                $data['tickets'] = $tickets;
            }
        }
        return $this->save($data,$id);
    }


    public function buildMonthStatsQuery($year=null, $month = null)
    {
        if(!$month) $month = date('m');
        if(!$year)  $year  = date('Y');
        $args = [
            'status' => 100,
            '@actions' => [
                ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
                ['join', 'buses','buses.id','=','schedules.bus_id'],
                ['join','routes','routes.id','=','schedules.route_id'],
                // ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
                // ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],

                ['whereYear','completed_at',$year],
                ['whereMonth','completed_at', $month],
                ['where', function($query){
                    $query->where(function($q){
                        $q->where('routes.from_id', get_station_id())
                            ->where('schedules.direction', 1);
                    })->orWhere(function($q){
                        $q->where('routes.from_id', '!=', get_station_id());
                    });
                }]
            ],
            '@select' => [
                'trips.*', 'schedules.direction', 'routes.name as route_name', 'routes.type as route_type', 
                'routes.from_id', 'routes.to_id', 'start_stations.name as from_station', 'end_stations.name as to_station',
                'buses.license_plate'
            ]
        ];

        return $args;
    }

    public function countMonthForward($year=null, $month = null)
    {
        $args = $this->buildMonthStatsQuery($year, $month);
        unset($args['@select']);
        return $this->count($args);
    }

    public function countMonthTickets($year = null, $month = null)
    {
        if($year){
            $this->whereYear('checkout_at', $year);
            if($month){
                $this->whereMonth('checkout_at', $month);
            }
        }
        $args = [
            'status' => 100,
            'routes.from_id' => get_station_id(),
            'schedules.direction' => 1,
            '@actions' => [
                ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
                ['join', 'buses','buses.id','=','schedules.bus_id'],
                ['join','routes','routes.id','=','schedules.route_id']
            ],
            '@selectRaw' => "SUM(trips.tickets) as ticket_count",
            '@groupBy' => [DB::raw("CONCAT_WS('-', YEAR(checkout_at), MONTH(checkout_at))")]
        ];
        $count = 0;
        if($rs = $this->first($args)){
            $count = $rs->ticket_count;
        }
        return $count;
    }
    
    public function getForwardChartsData($days = 7)
    {
        $data = [];
        $args = [
            'status' => 100,
            'routes.from_id' => get_station_id(),
            'schedules.direction' => 1,
            '@actions' => [
                ['join', 'schedules', 'trips.schedule_id', '=', 'schedules.id'],
                ['join','routes','routes.id','=','schedules.route_id']
            ],
            '@where' => ['started_at','>=',Carbon::now()->subDays($days)],
            '@selectRaw' => 'count(trips.id) as trip_total, date(trips.started_at) as trip_date',
            
        ];
        $this->groupBy(DB::raw('DATE(trips.started_at)'));
        if($tm = $this->get($args)){
            $data = $tm;
        }
        return $data;
    }

}