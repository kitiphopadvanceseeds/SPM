<?php


namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class dEmployee extends Authenticatable
{
    use Notifiable;


    protected $table = 'dEmployee';
    protected $primaryKey = 'idPs';
    public $incrementing = false;
    public $timestamps = false;
    // ชื่อ field ที่เราต้องการดึงมาใช้งาน
    protected $fillable = [
        'PsNameF',
        'psNameS',
        'PW',
        'UN',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'PW',
    ];




    public function getAuthPassword()
    {
        return $this->PW;
    }

    /**
     * ดึงชื่อเต็มของพนักงาน
     *
     * @return string
     */
    public function getFullnameAttribute(): string
    {
        $fullName = trim(($this->PsNameF ?? '') . ' ' . ($this->psNameS ?? ''));
        return $fullName !== '' ? $fullName : ($this->UN ?? 'User');
    }
}
