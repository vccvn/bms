<?php

namespace App\Repositories\Comments;

/**
 * @created doanln  2018-04-08
 */
use App\Repositories\EloquentRepository;

class CommentRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Comment::class;
    }


    /**
     * lay ra danh sach comment dc comment o post
     * @param array $args       mang tham so
     * 
     * @return items
     */
    public function getCommentOnPost($args = [])
    {
        $a = (array) $args;
        $a['object'] = 'post';
        return parent::get($args,'comments');
    }

    /**
     * lay ra danh sach comment dc comment o product
     * @param array $args       mang tham so
     * 
     * @return items
     */
    public function getCommentOnProduct($args = [])
    {
        $a = (array) $args;
        $a['object'] = 'product';
        return parent::get($args,'comments');
    }

    /**
     * lay ra danh sach comment dc comment o page
     * @param array $args       mang tham so
     * 
     * @return items
     */
    public function getCommentOnPage($args = [])
    {
        $a = (array) $args;
        $a['object'] = 'page';
        return parent::get($args,'comments');
    }

    public function filter($request, $object = 'all', $args = [])
    {
        $a = (array) $args;
        $ob = strtolower($object);
        $o = null;
        if(in_array($ob, ['page', 'post', 'product','help'])){
            $a['object'] = $ob;
            $o = $ob.'s';
        }
        // filter
        $orderby = [];
        if ($request->sortby) {
            $orderby[$request->sortby] = $request->sorttype;
        }else{
            $orderby['created_at'] = 'DESC';
        }
        $ar = [            
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['author_name', 'author_email']
            ],
            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10)
        ];

        if($o){
            $ar['object'] = $o;
            switch ($ob) {
                case 'post':
                    $ar['@selectRaw'] = 'comments.*, posts.title as post_title';
                    $ar['@join'] = ['posts', 'posts.id', '=', 'comments.object_id'];
                    break;
                
                case 'product':
                    $ar['@selectRaw'] = 'comments.*, products.name as product_name';
                    $ar['@join'] = ['products', 'products.id', '=', 'comments.object_id'];
                    break;
                
                case 'page':
                    $ar['@selectRaw'] = 'comments.*, posts.title as page_title';
                    $ar['@join'] = ['posts', 'posts.id', '=', 'comments.object_id'];
                    break;
                
                case 'dynamic':
                    $ar['@selectRaw'] = 'comments.*, posts.title as page_title';
                    $ar['@join'] = ['posts', 'posts.id', '=', 'comments.object_id'];
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        $arg = array_merge($ar,$a);
        $list = $this->get($arg,'comments');
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

    public function approve($id)
    {
        if($cmt = $this->find($id)){
            if($this->save(['approved'=>1], $id)){
                return true;
            }
        }
        return false;
    }

    public function unapprove($id)
    {
        if($cmt = $this->find($id)){
            if($this->save(['approved'=>0], $id)){
                return true;
            }
        }
        return false;
    }

    
    

    
}
