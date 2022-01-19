<?php

/**
 * @author DoanLN
 * @date 2018-10-01
 * @description 
 * cho phép tạo ra các đối tượng từ màng, 
 * truy cập cào các phần tử của mảng thông qua key bằng tên thuộc tính của đối tượng
 * 
 */

namespace Cube;

class Parameter extends Any {
    /**
     * sql functions
     * @var array $sqlclause
     */
    protected $sqlclause = [
        // select
        'select','selectRaw',
        // from
        'from','fromRaw',
        // join
        'join','leftJoin','crossJoin',
        // where
        'where','whereRaw','whereIn','whereNotIn','whereBetween','whereNotBetween', 'whereDay', 'whereMonth', 'whereYear', 
        'whereDate',
        'whereColumn',
        // orWhere
        'orWhere','orWhereRaw','orWhereIn','orWhereNotIn','orWhereBetween','orWhereNotBetween', 'orWhereDay', 'orWhereMonth', 
        'orWhereYear', 'orWhereDate', 
        'orWhereColumn',
        // group by
        'groupBy',
        // having
        'having','havingRaw',
        // order by
        'orderBy','orderByRaw',
        // limit
        'skip','take',
    ];

    /**
     * them chuoi tim kiem
     * @param string $keywords
     * @param string/array $search_by
     * 
     * @return object
     */
    public function search(string $keywords = null, $search_by = null)
    {
        $this->__data['@search'] = [
            'keyword' => $keywords,
            'by' => $search_by
        ];
        return $this;
    }

    /**
     * order by
     * @param mixed
     * @param string
     */
    public function order_by($column = null, $type='asc')
    {
        $orderby = is_array($column)?$column:[$column=>$type];
        if(array_key_exists('@order_by', $this->__data)){
            $this->__data['@order_by'] = array_merge($this->__data['@order_by'], $orderby);
        }else{
            $this->__data['@order_by'] = $orderby;
        }
        return $this;
    }

    public function limit($start=null,$length=0)
    {
        if(is_array($start)){
            $this->__data['@limit'] = $start;
        }elseif($length){
            $this->__data['@limit'] = [$start, $length];
        }else{
            $this->__data['@limit'] = $start;
        }
        return $this;
    }


	public function __call($method, $params)
	{
		if (in_array($method, $this->sqlclause)) {
            if(!isset($this->__data['@actions'])){
                $this->__data['@actions'] = [];
            }
			$this->__data['@actions'][] = array_merge([$method], $params);
        }
        return $this;
    }
    
    public function __toString()
    {
        return json_encode($this->__data);
    }
}