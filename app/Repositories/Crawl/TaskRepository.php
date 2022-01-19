<?php

namespace App\Repositories\Crawl;
use App\Repositories\EloquentRepository;
use App\Models\CrawlFrame;
use App\Models\CrawlTask;
use GuzzleHttp\Client;
use Carbon\Carbon;

class TaskRepository extends EloquentRepository 
{
    protected $crawl;

    public function getModel(){
        $this->crawl = new CrawlPostRepository();
        return CrawlTask::class;
    }

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
                'by' => 'url'
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


    public function run($id){
        set_time_limit(0);
        if(!$data = $this->find($id)) return false;
        $data->crawl_last_time = date('G:i:s', time());
        $data->datetime_crawl = Carbon::now();
        $data->save();
        $html = $this->crawl->get_html($data->url);
        if(!$html){
            return false;
        }
        if(!$frame = CrawlFrame::find($data->frame_id)){
            return false;
        }
        $task = [
            'cate_id' => $data->cate_id,
            'frame_id' => $data->frame_id,
            'user_id' => $data->user_id,
            'dynamic_id' => $data->dynamic_id
        ];
        $post = $html->find($data->url_post);
        $num = count($post) <= $data->quantity ? count($post) : $data->quantity;
        $count = 0;
        for($i = 0; $i < $num; $i++){
            if($post[$i] && $post[$i]->attr['href']){
                $task['url'] = strpos($post[$i]->attr['href'], 'http') === 0 ? $post[$i]->attr['href'] : $frame->url.$post[$i]->attr['href'];
                $res = $this->crawl->crawl($task);
                if($res)
                    $count++;
            }
        }
        
        // if(count($list_post)>0)
        //     Mail::to(env('EMAIL_NOTIFY'))->send(new NotifyCrawl($list_post, $data->url));
        return $count;
    }

}