<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ตารางบันทึกสคริป 
class PdIndexJobDt extends Model
{
    use HasFactory;
    protected $table = "GR_Group.dbo.PdIndexJobDt";
    protected $primaryKey = 'idJob'; #primaryKeyหลักในตารางของฐานข้อมูลนั้นๆ
    // public $incrementing = true; 
    public $timestamps = false;  #เวลาสร้างมันจะบอกระบุเวลา
}
