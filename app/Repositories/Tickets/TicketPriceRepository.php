<?php

namespace App\Repositories\Tickets;

/**
 * @created doanln  2018-11-16
 */
use App\Repositories\EloquentRepository;

class TicketPriceRepository extends EloquentRepository
{

    protected $where_args = [
        '@actions' => [
            ['join', 'routes', 'routes.id', '=', 'ticket_prices.route_id'],
            ['join', 'companies', 'companies.id', '=', 'ticket_prices.company_id'],
            ['leftJoin', 'stations as start_stations', 'start_stations.id', '=', 'routes.from_id'],
            ['leftJoin', 'stations as end_stations', 'end_stations.id', '=', 'routes.to_id'],
            
        ],
        '@select' => [
            'ticket_prices.*',
            'routes.name as route',
            'companies.name as company',
            'start_stations.name as from_station', 
            'end_stations.name as to_station'
        ]
    ];

    protected $search_filter_by = [
        'route' => 'routes.name',
        'company' => 'companies.name'
    ];
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\TicketPrice::class;
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

        
        $search_by = ['routes.name'];
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
}