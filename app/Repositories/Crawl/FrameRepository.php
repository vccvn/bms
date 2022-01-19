<?php

namespace App\Repositories\Crawl;
use App\Repositories\EloquentRepository;
use App\Models\CrawlFrame;

class FrameRepository extends EloquentRepository {

    public function getModel(){
        return CrawlFrame::class;
    }

    public function saveFrame($request){
        $data = $request->all();
        $data['slug'] = $this->getSlug($request->slug?$request->slug:$request->name, $request->id);
        $frame = $this->save($data, $request->id);

        if ($request->hasFile('avatar') && $frame) {
            $file = $request->avatar;
            $frame->avatar = $this->uploadImages($file,'frames');
            $frame->save();
        }
        return $frame;
    }

    /**
     * @param $images
     * @param $folder
     * @return string
     */
    public function uploadImages($images,$folder)
    {
        $file = $images;
        $fileName =  uniqid() . $file->getClientOriginalName();
        $filePath = 'contents/'.$folder.'/';
        $destinationPath = public_path($filePath);
        $file->move($destinationPath, $fileName);
        return $fileName;

    }
    // private function to_slug($str) {
    //     $str = trim(mb_strtolower($str));
    //     $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    //     $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    //     $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    //     $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    //     $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    //     $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    //     $str = preg_replace('/(đ)/', 'd', $str);
    //     $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    //     $str = preg_replace('/([\s]+)/', '-', $str);
    //     return $str;
    // }


    /**
     * @param Request $request
     * @param array $args
     * @return Items
     */
    public function filter($request, $args = [])
    {
        $a = (array) $args;
        $p = [
            '@search' => [
                'keywords' => $request->s,
                'by' => ['name','url']
            ],
            '@paginate' => $request->perpage?$request->perpage:10
        ];
        if($request->sortby){
            $p['@order_by'] = [$request->sortby=>$request->sorttype];
        }else{
            $p['@order_by'] = ['created_at'=>'DESC'];
        }
        return $this->get(array_merge($p,$a));
    }
 
    /**
     * get user option 
     * @param array $args
     * @param boolean $with_email
     * 
     * @return array
     */
    public function getFrameSelectOPtions(array $args = [])
    {
        $options = ["Chọn nguồn"];
        if($list = $this->get($args)){
            foreach ($list as $item) {
                $options[$item->id] = $item->name;
            }
        
        }
        return $options;
    }

    /**
     * get user option 
     * @param boolean $with_email
     * 
     * @return array
     */
    public static function getSelectOption()
    {
        $self = new static();
        return $self->getFrameSelectOPtions();
    }

}