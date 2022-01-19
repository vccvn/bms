<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Cube\Files;
class FileController extends Controller
{
    //
    public function index()
    {
    	$file = new Files();

    	$file->cd('json');
    	$content = $file->text('icon');
    	$icons = [];
    	if(preg_match_all('/fa-([A-z0-9\-]*)?(\r|\n|$)/', $content, $m)){
    		foreach($m[1] as $icon){
    			if(!in_array($icon, $icons)){
    				$icons[] = $icon;
    			}
    		}
    	}
    	return response()->json($icons);
    }
    
    public function getIcon()
    {
    	
    }
}
