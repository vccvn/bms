<?php

namespace App\Repositories\Schedules;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use DB;
class ScheduleRepository extends EloquentRepository
{
    protected $relationsive_clause = [
        '@actions' => [
            ['join', 'buses','buses.id','=','schedules.bus_id'],
            ['join','routes','routes.id','=','schedules.route_id'],
            ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
            ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],
            ['leftJoin', 'trips', 'trips.schedule_id', '=', 'schedules.id'],
            
        ],
        '@select'=>[
            'schedules.*', 'buses.license_plate_clean as license_clean','buses.license_plate', 'routes.name as route_name',
            'routes.type as route_type', 'start_stations.name as start_station', 'end_stations.name as end_station'
        ],
        '@selectRaw' => "YEAR(schedules.active_date) as year, MONTH(schedules.active_date) as month, CONCAT(YEAR(schedules.active_date),'-', MONTH(schedules.active_date)) as date_month, CONCAT_WS('-',YEAR(schedules.active_date), MONTH(schedules.active_date), routes.type, schedules.bus_id, schedules.route_id, schedules.direction) as schedule_key, COUNT(trips.id) as trip_total"
    ];

    
   
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Schedule::class;
    }
    
    /**
     * loc ket qua
     * @param Request $request
     * @param int $year
     * @param int $month
     * @param int $day
     * @param array $args
     * @return Collection
     */
    public function filter($request, $year = null, $month = null, $day = null, $args = [])
    {
        $y = date('Y');
        if($year && $year!='all'){
            $this->whereYear('active_date',$year);
        }elseif(!$year){
            $this->whereYear('active_date',$y);
        }
        if($month && $month != 'all'){
            $this->whereMonth('active_date',$month);
        }elseif(!$month){
            $this->groupBy('bus_id')->groupBy(DB::raw('Year(schedules.active_date)'))->groupBy(DB::raw('Month(schedules.active_date)'));
            if($year == $y) $this->whereMonth('schedules.active_date',date('m'));
        }
        if($day){
            $this->whereDay('active_date',$day);
        }
        if($request->direction){
            $dr = strtolower($request->direction);
            if(!in_array($dr, ['*', 'all'])){
                if(in_array($dr, ['2', 'back'])){
                    $this->direction = 2;
                }else{
                    $this->direction = 1;
                }
            }
        }else{
            $this->direction = 1;
        }

        $orderby = [];
        $sb = strtolower($request->sortby);
        if($sb && in_array($sb, $this->getFields())){
            $orderby[$sb] = $request->sorttype;
            
        }else{
            $this->orderByRaw('date_month asc');
        }

        $search = $request->s;
        
        $search_by = ['active_date','bus_id'];
        $sb = strtolower($request->searchby);
        if($sb && (in_array($sb, $this->getFields()) || $sb == 'license_plate')){
            if($sb == 'license_plate'){
                $search_by = 'buses.license_plate_clean';
                $search = str_slug($search,'');
            }else{
                $search_by = $sb;
            }
        }

        $args = array_merge([
            // search
            '@search' => [
                'keyword' => $search,
                'by' => $search_by
            ],
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10)
        ], (array) $args);
        $args = array_merge($this->relationsive_clause, $args);
        $fields = $request->all();
        if($fields){
            foreach ($fields as $key => $value) {
                if(in_array($k = strtolower($key), $this->getFields())){
                    $args[$k] = $value;
                }elseif($k == 'license_plate'){
                    $args['buses.license_plate_clean'] = str_slug($value,'');
                }
            }
        }
        $this->groupBy(DB::raw("CONCAT_WS('-',YEAR(schedules.active_date), MONTH(schedules.active_date), routes.type, schedules.bus_id, schedules.route_id, schedules.direction)"));
        $list = $this->getOnly($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;

    }

    
    /**
     * luu lịch trinh
     * @param App\Models\Bus $bus
     * @param int $direction
     * @param int $year
     * @param int $month
     * @param int $day
     * 
     * @return collection
     */
    public function getSchedules($bus = null, $direction = 0, $year = null, $month = null, $day = null)
    {
        $schedules = [];
        if($bus) $this->bus_id = $bus->id;
        if($direction) $this->direction = $direction;
        if($year){
            $this->whereYear('active_date',$year);
        }
        if($month){
            $this->whereMonth('active_date',$month);
        }
        if($day){
            $this->whereDay('active_date',$day);
        }
        
        $this->orderBy('active_date','ASC');
        if(count($list = $this->get())){
            $schedules = $list;
        }
        
        return $schedules;
    }
    
    /**
     * luu lịch trinh
     * @param App\Models\Bus $bus
     * @param int $direction
     * @param int $year
     * @param int $month
     * @param int $day
     * 
     * @return array
     */
    public function getScheduleDates($bus = null, $direction = 0, $year = null, $month = null, $day = null)
    {
        $schedules = [];
        if(count($list = $this->getSchedules($bus, $direction, $year, $month, $day))){
            foreach ($list as $item) {
                $schedules[] = $item->active_date;
            }
        }
        return $schedules;
    }

    /**
     * luu lịch trinh
     * @param App\Models\Bus $bus
     * @param int $direction
     * @param int $year
     * @param int $month
     * @param array $active_dates
     * 
     * @return array mang schedule id
     */
    public function saveSchedules($bus, $direction=1, $year, $month, $active_dates)
    {
        $active_dates = (array) $active_dates;
        $data = [];
        $setting = getSetting();
        $bus_id = $bus->id;
        $route_id = $bus->route_id;
        $date_exists = [];
        $after_date = date('Y-m-d', strtotime(date('Y-m-d'))+3600*24*$setting->schedule_days_before(0));
        $list = $this->whereYear('active_date',$year)
                    ->whereMonth('active_date',$month)
                    ->whereDate('active_date','>=', $after_date)
                    ->get(compact('bus_id','direction'));
        $date_remove = [];
        $date_data = [];

        if(count($list)){
            foreach ($list as $s) {
                $date_data[] = $s->active_date;
                if(in_array($s->active_date, $active_dates)){
                    $data[] = $s;
                    $date_remove[] = $s->active_date;
                }else{
                    $s->delete();
                }
            }
        }
        if(is_array($active_dates) && count($active_dates)){
            foreach($active_dates as $active_date){
                if(!in_array($active_date, $date_remove)){
                    $sc = $this->save(compact('bus_id','route_id','direction', 'active_date'));
                    $data[] = $sc;
                }
            }
        }
        return $data;
    }
}