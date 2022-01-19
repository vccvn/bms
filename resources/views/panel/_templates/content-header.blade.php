<?php 
use Illuminate\Support\Facades\Input;
?>
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> @yield('title')
                    @yield('affter_page_title')    
                </h3>
                
            </div>
        </div>
    </div>
    <div class="items-search">
        <form class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control boxed rounded-s" name="s" value="{{Input::get('s')}}" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-secondary rounded-s" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>