<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//ตารางอันที่ 2 บันทึกพวก จำนวนที่รับเมล็ด
class PdIndexJobRecPack extends Model
{
    use HasFactory;
    protected $table = "GR_Group.dbo.PdIndexJobRecPack";

    protected $primaryKey = 'idJobRecPack'; #primaryKeyหลักในตารางของฐานข้อมูลนั้นๆ
    // public $incrementing = true; 
    public $timestamps = false;  #เวลาสร้างมันจะบอกระบุเวลา
}
