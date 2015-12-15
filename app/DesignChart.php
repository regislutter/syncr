<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignChart extends Model
{
    protected $table = 'designcharts';

    protected $fillable = ['font_serif', 'font_sans_serif', 'font_size', 'line_height',
        'background_color', 'primary_color', 'secondary_color', 'info_color', 'success_color', 'warning_color', 'alert_color',
        'title_h1_font', 'title_h1_color', 'title_h1_font_size', 'title_h1_line_height',
        'title_h2_font', 'title_h2_color', 'title_h2_font_size', 'title_h2_line_height',
        'title_h3_font', 'title_h3_color', 'title_h3_font_size', 'title_h3_line_height',
        'title_h4_font', 'title_h4_color', 'title_h4_font_size', 'title_h4_line_height',
        'title_h5_font', 'title_h5_color', 'title_h5_font_size', 'title_h5_line_height',
        'title_h6_font', 'title_h6_color', 'title_h6_font_size', 'title_h6_line_height',
        'text_font', 'text_color', 'text_font_size', 'text_line_height',
        'breakpoint_mobile', 'breakpoint_tablet', 'breakpoint_desktop'
        ];

    public function project(){
        return $this->hasOne('App\Project');
    }
}
