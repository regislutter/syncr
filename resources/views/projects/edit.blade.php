@extends('layouts.master')

@section('title', 'Edit project: '.$project->name)

@section('content')
    <h1>Edit project: {{ $project->name }}</h1>

    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span class="alert round label">{{ $error }}</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($project, array('url' => route('project.update', $project->id), 'method' => 'put')) !!}

    <div class="row">
        <div class="large-12 columns">
            {!! Form::label('name', 'Name') !!}{!! Form::text('name') !!}
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns">
            {!! Form::label('client', 'Client') !!}{!! Form::select('client', $clientsList, $project->client->id) !!}
            <a class="button tiny" href="{{ route('client.create') }}">Create new client</a>
        </div>
    </div>


    <h3>Design chart</h3>
    <ul class="accordion" data-accordion>
        <li class="accordion-navigation">
            <a href="#panel1a">Fonts</a>
            <div id="panel1a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('font_sans_serif', 'Font Sans Serif') !!}{!! Form::text('font_sans_serif') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('font_serif', 'Font Serif') !!}{!! Form::text('font_serif') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('font_size', 'Default font size (Ex: 16px)') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('line_height', 'Default line-height (Ex: 22px)') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel2a">Colors (hexadecimal)</a>
            <div id="panel2a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('background_color', 'Background color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('background_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('info_color', 'Info color (Ex: blue)') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('info_color') !!}
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('primary_color', 'Primary color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('primary_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('success_color', 'Success color (Ex: green)') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('success_color') !!}
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('secondary_color', 'Secondary color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('secondary_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('warning_color', 'Warning color (Ex: orange)') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('warning_color') !!}
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="large-6 medium-6 columns">
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('alert_color', 'Alert color (Ex: red)') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('alert_color') !!}
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel3a">Text (paragraph)</a>
            <div id="panel3a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('text_font', 'Text font') !!}{!! Form::text('text_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('text_font_size', 'Text font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('text_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('text_color', 'Text color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('text_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('text_line_height', 'Text line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('text_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel4a">Title H1</a>
            <div id="panel4a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('title_h1_font', 'H1 font') !!}{!! Form::text('title_h1_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h1_font_size', 'H1 font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h1_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('title_h1_color', 'H1 color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h1_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h1_line_height', 'H1 line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h1_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel5a">Title H2</a>
            <div id="panel5a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('title_h2_font', 'H2 font') !!}{!! Form::text('title_h2_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h2_font_size', 'H2 font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h2_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('title_h2_color', 'H2 color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h2_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h2_line_height', 'H2 line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h2_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel6a">Title H3</a>
            <div id="panel6a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('title_h3_font', 'H3 font') !!}{!! Form::text('title_h3_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h3_font_size', 'H3 font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h3_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('title_h3_color', 'H3 color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h3_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h3_line_height', 'H3 line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h3_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel7a">Title H4</a>
            <div id="panel7a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('title_h4_font', 'H4 font') !!}{!! Form::text('title_h4_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h4_font_size', 'H4 font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h4_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('title_h4_color', 'H4 color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h4_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h4_line_height', 'H4 line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h4_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel8a">Title H5</a>
            <div id="panel8a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('title_h5_font', 'H5 font') !!}{!! Form::text('title_h5_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h5_font_size', 'H5 font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h5_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('title_h5_color', 'H5 color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h5_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h5_line_height', 'H5 line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h5_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel9a">Title H6</a>
            <div id="panel9a" class="content">
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        {!! Form::label('title_h6_font', 'H6 font') !!}{!! Form::text('title_h6_font') !!}
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h6_font_size', 'H6 font-size') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h6_font_size') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse prefix-radius">
                            <div class="small-4 columns">
                                {!! Form::label('title_h6_color', 'H6 color') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="prefix">#</span>
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h6_color') !!}
                            </div>
                            <div class="small-5 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-6 medium-6 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('title_h6_line_height', 'H6 line-height') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('title_h6_line_height') !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel10a">Breakpoints</a>
            <div id="panel10a" class="content">
                <div class="row">
                    <div class="large-4 medium-4 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('breakpoint_mobile', 'Mobile (Ex: 480px)') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('breakpoint_mobile', 480) !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('breakpoint_tablet', 'Tablet (Ex: 768px)') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('breakpoint_tablet', 768) !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                    <div class="large-4 medium-4 columns">
                        <div class="row collapse postfix-radius">
                            <div class="small-6 columns">
                                {!! Form::label('breakpoint_desktop', 'Desktop (Ex: 1024px)') !!}
                            </div>
                            <div class="small-2 columns">
                                {!! Form::text('breakpoint_desktop', 1024) !!}
                            </div>
                            <div class="small-1 columns">
                                <span class="postfix">px</span>
                            </div>
                            <div class="small-3 columns">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <br/>

    <div class="row">
        <div class="large-12 columns">
            <a class="button small round secondary" href="{{ route('project.show', $project->id) }}">Cancel</a>
            {!! Form::submit('Edit project', array('class' => 'button small round success')) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop