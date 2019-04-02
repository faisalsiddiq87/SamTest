<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Product extends Model 
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

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
	protected $fillable = ['name', 'price', 'description', 'created_by', 'updated_by'];

	public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}