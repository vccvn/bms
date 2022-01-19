<?php

namespace App\Repositories\Crawl;
use App\Repositories\EloquentRepository;
use App\Models\CrawlFrame;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Tags\TagLinkRepository;


use App\Repositories\Dynamic\DynamicRepository;
use Sunra\PhpSimple\HtmlDomParser;

use Cube\Image;

use Carbon\Carbon;

use Cube\Any;

use App\Apis\Api;

class CrawlPostRepository extends PostRepository 
{
    /**
     * 
     */
    protected $frames = null;

    protected $tags = null;

    protected $links = null;

    protected $api = null;
    public function __construct()
    {
        parent::__construct();
        $this->addFixableParam('status',200);
        $this->frames = new FrameRepository();
        $this->tags = new TagRepository();
        $this->links = new TagLinkRepository();
        $this->api = new Api();
        $this->dynamics = new DynamicRepository();
        $this->dynamics->addFixableParam('status',200);
        $this->dynamics->addDefaultParam('parent_id',0);
    }


    /**
     * crawl post
     * @param array $args 
     * 
     * @return App\Models\Post
     */
    public function crawl(array $args = []){
        
        $req = new Any($args);
        
        // nếu ko tìm dc frame thì trả vè false
        if(!$req->frame_id || !$frame = $this->frames->find($req->frame_id)) return false;

        $url = strpos($req->url, 'http') === 0 ? $req->url : rtrim($frame->url, '/').'/'.ltrim($req->url);
        $html = $this->get_html($url);
        
        // nếu ko lấy dc nội dung trang web
        if(!$html) return false;
            
        $list_content = explode('|', $frame->content);
        $content = '';
        
        foreach($list_content as $value){
            if($content == '' && $value && $value != ''){
                $content = $this->getContent($html->find($value, 0), null);
            }
                
        }
        
        if($content == '') return false;
        $data = [
            'title' => $this->getContent($html->find($frame->title, 0), $frame->attr_title),
            'description' => $this->getContent($html->find($frame->description, 0), $frame->attr_description),
            'content' => $this->except($content, $frame->except, $frame),
            'cate_id' => $req->cate_id,
            'user_by'=> $req->user_id,
            
        ];
        
        $qid = uniqid();
        if( $data['title'] == '' ||  $data['content'] == '') return false;
        
        $data['content'] .= $frame->style;
        $data['slug'] = str_slug($data['title'], '-');

        $meta = [];
        $meta['frame_id'] = $req->frame_id;
        $meta['user_id'] = $req->user_id;
        $meta['url'] = $url;
        $meta['meta_title'] = $data['title'];
        $meta['meta_description'] = $data['description'];
        $meta['qid'] = $qid;
        
        if($req->dynamic_id && $dynamic = $this->dynamics->findBy('id',$req->dynamic_id)){
            $this->dynamics->resetDefaultParams();
            
            if($this->dynamics->first(['slug'=> $data['slug'], 'parent_id'=>$req->dynamic_id])) return false;
            else{
                $data['cate_map'] = $this->dynamics->makeCateMap($req->cate_id);
                $data['parent_id'] = $req->dynamic_id;
                $image =  $this->getContent($html->find($frame->image, 0),  $frame->attr_image);
                $url = strpos($image, 'http') === 0 ? $image : $frame->url.$image;
                // lưu file ảnh 
                $data['feature_image'] = @$this->saveFeatureImage($url, $qid, 'dynamics');
                // lưu bài viết
                $post = $this->dynamics->save($data);
                 // luu nwta
                if($post){
                    $this->dynamics->saveManyMeta($post->id,$meta);
                    if($tags = $this->addTag($html, $frame->tag, $frame->attr_tag)){
                        $this->links->saveDynamicTags($post->id,$tags);
                    }
                    // cập nhật nội dung nếu có ãnh
                    $this->dynamics->save(['content' => $this->saveResources($frame, $data['content'], $qid, 'dynamics')], $post->id);
                    return $post;
                }
                return false;
            }
        }
        elseif($this->findBy('slug', $data['slug'])) return false;
        else{
            $data['cate_map'] = $this->makeCateMap($req->cate_id);    
            $image =  $this->getContent($html->find($frame->image, 0),  $frame->attr_image);
            $url = strpos($image, 'http') === 0 ? $image : $frame->url.$image;
            // lưu file ảnh 
            $data['feature_image'] = @$this->saveFeatureImage($url, $qid);
            // lưu bài viết
            $post = $this->save($data);
             // luu nwta
            if($post){
                $this->saveManyMeta($post->id,$meta);
                if($tags = $this->addTag($html, $frame->tag, $frame->attr_tag)){
                    $this->links->savePostTags($post->id,$tags);
                }
                // cập nhật nội dung nếu có ãnh
                $this->save(['content' => $this->saveResources($frame, $data['content'], $qid)], $post->id);
                return $post;
            }
            return false;
        }
    }

    // để làm gì thì chịu
    public function except($string, $except, $frame){
        $string = HtmlDomParser::str_get_html($string);
        if($string == '')
            return '';
        foreach($string->find('figure') as $v){
            $v->attr = [];
        }
        $string->load($string->save());
        foreach($string->find('a') as $v){
            unset($v->attr['href']);
        }
        // $string->load($string->save());
        // foreach($string->find('table') as $value){
        //     $value->outertext.='<br>';
        // }
        $string->load($string->save());
        $except = explode('^', $except);
        foreach($except as $v){
            if($v != '')
                foreach ($string->find(trim($v)) as $value){
                    $value->outertext = '';
                };
        }
        $string->load($string->save());
        return $string;
    }

    public function saveResources($frame, $string, $qid) {
        $string = HtmlDomParser::str_get_html($string);
        foreach($string->find('video,source,img') as $value){
            if($value->attr['src']){
                if(isset($value->attr['src']) && $value->attr['src'] != ''){
                    $url = strpos($value->attr['src'], 'http') === 0 ? $value->attr['src'] : $frame->url.$value->attr['src'];
                    if($src = @$this->uploadFromUrl($url, $qid)){
                        $value->attr['src'] = $src;
                    }
                    
                }
            }
        }
        $string->load($string->save());
        return $string;
    }


    public function addTag($html, $tag, $attr_tag){
        $tag_list = [];
        
        foreach($html->find($tag) as $value){
            $tags = $this->getContent($value, $attr_tag);
            
            if($tagList = $this->tags->addTags($tags)){
                foreach ($tagList as $t) {
                    $tag_list[] = $t->id;
                }
            }
        }
        return $tag_list;
    }

    public function uploadFromUrl($url, $qid,$folder='posts'){
        $name = $qid.'-'.substr($url, strrpos($url, '/') + 1);
        $path = 'contents/'.$folder.'/'.$name;
        
        $contents = @file_get_contents($url);
        $fp = public_path($path);
        @file_put_contents($fp, $contents);
        if(!file_exists($fp)) return null;
        return asset($path);
    }

    public function saveFeatureImage($url, $qid,$folder='posts'){
        $name = $qid.'-'.substr($url, strrpos($url, '/') + 1);
        $image = new Image($url);
        $image->save('contents/'.$folder.'/'.$name);
        $image->RaC(90,90);
        $image->save('contents/'.$folder.'/90x90/'.$name);
        return $name;
    }



    public function getContent($html, $attr){
        $result = '';
        if(isset($html->innertext)){
            if($attr){
                if(isset($html->attr[$attr]))
                    $result = $html->attr[$attr];
            }else
                $result = $html->innertext;
        }
        $result = preg_replace('/&#39;/', '', trim($result));
        return preg_replace('/&quot;/', '"', $result);
    }


    public function get_html($url){
        if(count(explode('zing.vn/', strtolower($url)))>1){
            try{
                $rs = $this->api->send('GET',$url);
                $content = $rs->getBody()->getContents();
            }catch(exception $e){
                $content = null;
            }
        }
        else{
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content = curl_exec($ch);
            curl_close($ch);
        }
        
        
        return HtmlDomParser::str_get_html($content);
    }


}