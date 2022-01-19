<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

use Validator;
use App\Repositories\Tickets\TicketPriceRepository;

class TicketPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id;
        $company_id = $this->company_id;
        Validator::extend('unique_route_company', function($attr, $value) use($id, $company_id) {
            if($ticket = (new TicketPriceRepository)->first(['company_id'=>$company_id, 'route_id'=>$value])){
                if($id && $id == $ticket->id) return true;
                return false;
            }
            return true;
        });

        $rules = [
            "company_id"                  => 'required|exists:companies,id',
            'route_id'                    => 'required|exists:routes,id|unique_route_company',
            "price"                       => 'numeric|min:0'
        ];
        return $rules;
        
    }

    public function messages()
    {
        return [
            "company_id.exists"           => 'Nhà xe này không tồn tại!',
            'route_id.exists'             => 'Tuyến xe này không tồn tại',
            'route_id.unique_route_company'=>'Mỗi nhà xe chỉ được niêm yết một giá vé cho mỗi tuyến.',
            "price.*"                     => 'Trọng lượng không hợp lệ'
        ];
    }
}
