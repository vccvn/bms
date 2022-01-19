<?php 
use Illuminate\Support\Facades\Input;
$su = isset($search_route)?route($search_route):(isset($search_url)?$search_url:null);
?>
<div class="items-search">
    <form class="form-inline" method="get" action="{{$su}}">
        <div class="input-group">
            <input type="text" class="form-control boxed rounded-s" name="s" value="{{Input::get('s')}}" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-secondary rounded-s" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>
</div>