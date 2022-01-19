<?php
namespace App\Statistics;

class BmsStatistic extends Statistic
{
    

    public function getMonthStats($year=null, $month = null)
    {
        if(!$month) $month = date('m');
        if(!$year)  $year  = date("Y");

        $last_year = $year;
        $last_month = $month -1;
        if($last_month == 0){
            $last_month = 12;
            $last_year--;
        }
        // luot xuất bến
        
        $month_trips = $this->trips->countMonthForward($year, $month);
        if(!$month_trips) $month_trips = 0;
        $last_month_trips = $this->trips->countMonthForward($last_year, $last_month);
        if(!$last_month_trips) $last_month_trips = 1;

        // Số xe hoạt động
        $month_buses = $this->bus->countBusActive($year, $month);
        $last_month_buses = $this->bus->countBusActive($last_year, $last_month);
        if(!$last_month_buses) $last_month_buses = 1;

        // Số xe đang ký hoạt dộng mới
        $month_buses_register = $this->bus->countBusRegister($year, $month);
        $last_month_buses_register = $this->bus->countBusRegister($last_year, $last_month);
        if(!$last_month_buses_register) $last_month_buses_register = 1;


        // Số nhà xe
        $month_companies_register = $this->companies->countRegister($year, $month);
        $last_month_companies_register = $this->companies->countRegister($last_year, $last_month);
        if(!$last_month_companies_register) $last_month_companies_register = 1;


        // Số tuyến mới mở
        $month_routes_opened = $this->routes->countOpened($year, $month);
        $last_month_routes_opened = $this->routes->countOpened($last_year, $last_month);
        if(!$last_month_routes_opened) $last_month_routes_opened = 1;


        // tong so ve tuyen xe khach ban dc trong thang

        $month_tickets = $this->trips->countMonthTickets($year, $month);
        if(!$month_tickets) $month_tickets = 0;
        
        $last_month_tickets = $this->trips->countMonthTickets($last_year, $last_month);
        if(!$last_month_tickets) $last_month_tickets = 1;

        
        

        return compact(
            'month_trips', 'last_month_trips', 
            'month_buses', 'last_month_buses',
            'month_buses_register', 'last_month_buses_register', 
            'month_companies_register', 'month_companies_register',
            'month_routes_opened', 'last_month_routes_opened',
            'month_tickets', 'last_month_tickets'
        );
    }
}
