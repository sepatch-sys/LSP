<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'room_id',
        'name',
        'email',
        'phone',
        'guest_count',
        'check_in',
        'check_out',
        'total_price',
        'status_payment',
        'status_reservation'
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REFUNDED = 'refunded';

    public static function getStatusPayment()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_REFUNDED => 'Refunded',
        ];
    }

    public function updateStatusPayment($newStatus)
    {
        if (!in_array($newStatus, array_keys(self::getStatusPayment()))) {
            throw new \InvalidArgumentException("Status Not Valid.");
        }

        $this->status_payment = $newStatus;
        $this->save();
    }

    const STATUS_RESERVATION_PENDING = 'pending';
    const STATUS_RESERVATION_CHECKIN = 'checkin';
    const STATUS_RESERVATION_CHECKOUT = 'checkout';
    const STATUS_RESERVATION_CANCELLED = 'cancelled';

    public static function getStatusReservation()
    {
        return [
            self::STATUS_RESERVATION_PENDING => 'Pending',
            self::STATUS_RESERVATION_CHECKIN => 'Check In',
            self::STATUS_RESERVATION_CHECKOUT => 'Check Out',
            self::STATUS_RESERVATION_CANCELLED => 'Cancelled',
        ];
    }
    
    public function updateStatusReservation($newStatus)
    {
        if (!in_array($newStatus, array_keys(self::getStatusReservation()))) {
            throw new \InvalidArgumentException("Status Not Valid.");
        }

        $this->status_reservation = $newStatus;
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
