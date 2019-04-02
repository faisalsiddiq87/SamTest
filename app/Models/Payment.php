<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Payment extends Model 
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payments';

    /**
	 * Set timestamps by default if not given
	 *
	 * @timestamp string
	 */
	public $timestamps = true;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['order_id', 'amount', 'status', 'created_by'];

	public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
	}
	
	public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}