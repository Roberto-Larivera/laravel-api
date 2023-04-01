<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type_id',
        'name_repo',
        'link_repo',
        'featured_image',
        'description',
        'publish'
    ];

    // in caso vuoi nascondere questo attributo dalla risposta in json puoi inserirlo suu hidden
    // questo non influenza il model in chiamata esempio::: $project->featured_image
    //
    // protected $hidden = [
    //     'featured_image'
    // ];




    // 2 metodo per inserire url base (localhost... + storage/+img) creando un nuovo attributo (finta colonna database) che verrà chiamato ogni volta attraverso append
        /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_path_featured_image',
        'formatted_created_at',
    ];

    public function getFullPathFeaturedImageAttribute(){
        $fullPath = null;
        if($this->featured_image)
            $fullPath = asset('storage/'.$this->featured_image);
        return $fullPath;
    }

    public function getFormattedCreatedAtAttribute(){
        return date('Y-m-d H:i:s', strtotime($this->created_at));
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }
}
