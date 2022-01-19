<?php

namespace App\Repositories\Contacts;

/**
 * @created doanln  2018-04-08
 */
use App\Repositories\EloquentRepository;

class ContactReplyRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ContactReply::class;
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
                 'by' => ['name','email','phone_number']
             ],
             '@paginate' => $request->perpage?$request->perpage:10
         ];
         if($request->sortby){
             $p['@order_by'] = [$request->sortby=>$request->sorttype];
         }else{
            $p['@order_by'] = ['created_at'=>'DESC'];
        }
        $actions = [];
        if($request->from_date && isDate($request->from_date)){
            $actions[] = ['whereRaw', "DATE(created_at) >= '$request->from_date'"];
        }
        if($request->to_date && isDate($request->to_date)){
            $actions[] = ['whereRaw', "DATE(created_at) <= '$request->to_date'"];
        }
        if($actions){
            $p['@actions'] = $actions;
        }
         return $this->get(array_merge($p,$a));
     }
 
 
}
