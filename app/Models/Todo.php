<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property bool $done
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 */
class Todo extends Model
{
	protected $casts = [
		'user_id' => 'int',
		'done' => 'bool'
	];

	protected $fillable = [
		'name',
		'done'
	];

    protected $attributes = [
        'name' => '',
        'done' => false,
    ];

	/**
     * Get the user that owns the todo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
