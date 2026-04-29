<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'course',
        'year_level',
        'email',
        'phone',
        'profile_photo',
    ];

    /**
     * Get the student's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the student's initials for avatar placeholder.
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    /**
     * Get the JSON-encoded QR data string.
     */
    public function getQrDataAttribute(): string
    {
        return json_encode([
            'student_number' => $this->student_number,
            'name'           => $this->full_name,
            'course'         => $this->course,
            'year_level'     => 'Year ' . $this->year_level,
            'email'          => $this->email,
            'phone'          => $this->phone ?? 'N/A',
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Get the QR code image URL (via free external API — no package needed).
     */
    public function getQrCodeUrlAttribute(): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=M&data='
            . urlencode($this->qr_data);
    }

    /**
     * Get the profile photo URL or null.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->profile_photo
            ? asset('storage/profile_photos/' . $this->profile_photo)
            : null;
    }

    /**
     * Year level label.
     */
    public function getYearLabelAttribute(): string
    {
        $labels = [1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'];
        return $labels[$this->year_level] ?? 'Year ' . $this->year_level;
    }
}
