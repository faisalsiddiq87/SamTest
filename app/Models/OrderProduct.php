<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class OrderProduct extends Model 
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders_products';

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
	protected $fillable = ['order_id', 'product_id'];

	public function detail() 
	{
		return $this->belongsTo(Product::class, 'product_id');
	}
}