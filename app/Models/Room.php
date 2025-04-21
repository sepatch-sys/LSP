<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_room_id',
        'room_number',
        'price_night',
        'status',
        'description',
    ];

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_UNAVAILABLE = 'unavailable';
    public const STATUS_CLEANING = 'cleaning';
    public const STATUS_MAINTENANCE = 'maintenance';

    public static function getStatusLabel()
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_UNAVAILABLE => 'Unavailable',
            self::STATUS_CLEANING => 'Cleaning',
            self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }

    public function updateStatus($newStatus)
    {
        if (!in_array($newStatus, array_keys(self::getStatusLabel()))) {
            throw new \InvalidArgumentException("Status Not Valid.");
        }

        $this->status = $newStatus;
        $this->save();
    }

    public function typeRoom()
    {
        return $this->belongsTo(TypeRoom::class);
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
