<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = "user_logs";
    
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'text',
        'update_at', //修改人id
        'created_at',
        'updated_at',
    ];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function title()
    {
        $title = $this->title;
        $replace_examples = explode("*",$title);
        // $num = count($replace_example);
        foreach($replace_examples as $replace_example){
            echo $replace_example."<br>";
        }
    }

    public function text()
    {
        $text = $this->text;
        $replace_examples = explode("*",$text);
        // $num = count($replace_example);
        foreach($replace_examples as $replace_example){
            echo $replace_example."<br>";
        }
    }
}
