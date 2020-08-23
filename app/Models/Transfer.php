<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_APPROVED = 'approved';
    const STATUS_FINISHED = 'finished';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'status',
        'payer_id',
        'payee_id',
    ];

    protected $observables = [
        'transferUpdated',
    ];

    public function authorizedNow()
    {
        return $this->status === self::STATUS_APPROVED
            && $this->getOriginal('status') !== self::STATUS_APPROVED;
    }

    public function finishedNow()
    {
        return $this->status === self::STATUS_FINISHED
            && $this->getOriginal('status') !== self::STATUS_FINISHED;
    }

    public function canceledNow()
    {
        return $this->status === self::STATUS_CANCELED
            && $this->getOriginal('status') !== self::STATUS_CANCELED;
    }

    public function transferUpdated()
    {
        $this->fireModelEvent('updated', false);
    }
}
