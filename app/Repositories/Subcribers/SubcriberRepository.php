<?php

namespace App\Repositories\Subcribers;

/**
 * @created doanln  2018-04-08
 */
use App\Repositories\EloquentRepository;

class SubcriberRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Subcriber::class;
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
                 'by' => 'email'
             ],
             '@paginate' => $request->perpage?$request->perpage:10,
             'status' => 200
         ];
         if($request->sortby){
             $p['@order_by'] = [$request->sortby=>$request->sorttype];
         }else{
            $p['@order_by'] = ['created_at'=>'DESC'];
        }
         return $this->get(array_merge($p,$a));
     }
 
 
}
