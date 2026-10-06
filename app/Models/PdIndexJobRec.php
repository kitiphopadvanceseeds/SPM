<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ตารางบันทึกแรก
class PdIndexJobRec extends Model
{
    use HasFactory;

    protected $table = "GR_Group.dbo.PdIndexJobRec";

    protected $primaryKey = 'idJobRec'; #primaryKeyหลักในตารางของฐานข้อมูลนั้นๆ
    // public $incrementing = true; 
    public $timestamps = false;  #เวลาสร้างมันจะบอกระบุเวลา
}





