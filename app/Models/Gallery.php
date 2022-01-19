<?php

namespace App\Models;



class Gallery extends Model
{
    public $table = 'gallery';
    public $fillable = ['ref','ref_id','filename', 'original_filename'];
    public $_folder = 'galleries';
    
    public function getUrl()
    {
        return asset('contents/'.$this->_folder.'/'.$this->filename);
    }
    
    public function delete()
    {
        $path = public_path('contents/'.$this->_folder.'/'.$this->filename);
        if(file_exists($path)){
            unlink($path);
        }
        return parent::delete();
    }

}
