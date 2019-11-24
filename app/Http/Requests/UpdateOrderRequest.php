<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	    //Список доступных статусов. Возможно стоит унести куда нибудь, например в модель,
	    //Но пока проще так
	    $availableType = [
		    Order::STATUS_PROCESSING,
		    Order::STATUS_COMPLETED,
		    Order::STATUS_ON_HOLD,
		    Order::STATUS_CANCELED,
	    ];

	    return [
		    'status' => ['integer', 'in:' . implode(', ', $availableType)],
	    ];
    }
}
