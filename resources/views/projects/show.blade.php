@extends('layouts.master')

@section('title', 'Project : ' . $project->name)

@section('content')
    <h1><img data-src="/images/svg/smart/grid.svg" class="iconic iconic-md" alt="grid"> {{ $project->name }}</h1>
    <div class="small">Client: <a href="{{ route('client.show', $project->client->id) }}">{{ $project->client->name }}</a></div>
    @if(\Auth::user()->hasRight(\App\Right::PROJECT_SUBSCRIBE))
        @if(\Auth::user()->isSubscribed($project->id))
            <a class="button small round warning right" href="{{ route('unsubscribe.project', $project->id) }}"><span class="fi-eye-closed" title="unfollow" aria-hidden="true"></span> Unsubscribe</a>
        @else
            <a class="button small round success right" href="{{ route('subscribe.project', $project->id) }}"><span class="fi-eye-open" title="follow" aria-hidden="true"></span> Subscribe</a>
        @endif
    @endif
    @if(\Auth::user()->hasRight(\App\Right::COPYDECK_CREATE))
    <a class="button small round right" href="{{ route('copydeck.create', $project->id) }}"><span class="fi-plus" title="star" aria-hidden="true"></span> Create a new copydeck</a>
    @endif

    <h4>{{ $project->copydecks->count() }} Copydecks</h4>
    <table>
        <thead>
        <tr>
            <th width="200">Copydeck</th>
            <th>File name</th>
            <th>Server links</th>
            <th width="150">Last version</th>
            <th width="150">Deployed version</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @forelse($project->copydecks as $copydeck)
            <tr>
                <td><a href="{{ route('copydeck.show', [$copydeck->id]) }}">{{ $copydeck->name }}</a></td>
                <?php $file = $copydeck->files->last(); ?>
                <td>
                    @if(empty($file->link))
                        <strong>Online version</strong>
                    @else
                        {{ substr($file->link, strrpos($file->link, '/')+1) }}
                    @endif
                </td>
                <td>
                    <a class="label round" href="{{ substr($file->link, 0, strrpos($file->link, '/')) }}"><span class="fi-browser-type-safari" title="safari" aria-hidden="true"></span> Safari users</a>
                    <a class="copy-button label round" data-clipboard-text="{{ substr($file->link, 0, strrpos($file->link, '/')) }}" title="Click to copy the path."><span class="fi-browser-type-chrome" title="chrome" aria-hidden="true"></span> Other browsers</a>
                </td>
                <td>{{ $file->version }} - {{ $file->getStatusText() }}<br/><span class="small">{{ date('d M Y', strtotime($file['created_at']->toDateTimeString())) }}</span></td>
                <?php $lastFile = $copydeck->files()->where('status', \App\File::STATUS_DEPLOYED)->orderBy('status_updated_at', 'desc')->first(); ?>
                <td>@if($lastFile) {{ $lastFile->version }} <span class="small">- {{ date('d M Y', strtotime($lastFile->status_updated_at->toDateTimeString())) }}</span> @else None @endif</td>
                <td>
                    @if(\Auth::user()->hasRight(\App\Right::VERSION_CREATE))
                    <a href="{{ route('file.create', [$project->id, $copydeck->id]) }}" class="button tiny"><span class="fi-data-transfer-upload" title="upload" aria-hidden="true"></span> New version</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No copydeck in this project.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <ul class="accordion" data-accordion>
        <li class="accordion-navigation">
            <a href="#panel1a">Discussions</a>
            <div id="panel1a" class="content">
    <h4>Discussions</h4>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th width="100">Number of messages</th>
            <th width="150">Date last message</th>
            <th width="150">Date first message</th>
            <th width="150">Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($project->discussions as $discussion)
            <tr>
                <td><a href="{{ route('discussion.show', [$discussion->id]) }}">{{ $discussion->title }}</a></td>
                <td>{{ $discussion->direct_messages->count() }}</td>

                <?php $lastMessage = $discussion->direct_messages()->orderBy('created_at', 'desc')->first(); ?>
                <td>@if($lastMessage) {{ date('d M Y', strtotime($lastMessage->created_at->toDateTimeString())) }} @else None @endif</td>
                <td>{{ date('d M Y', strtotime($discussion->created_at->toDateTimeString())) }}</td>
                <td>
                    @if(\Auth::user()->hasRight(\App\Right::DELETE_DISCUSSION))
                        <a class="button tiny round alert" href="#">Close</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No discussion in this project. <a href="{{ route('project.discussion.create', $project->id) }}">Open the first discussion</a></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if(\Auth::user()->hasRight(\App\Right::CREATE_DISCUSSION))
        <a class="button tiny round left" href="{{ route('project.discussion.create', $project->id) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Create new discussion</a>
    @endif
                <br/><br/>
            </div>
        </li>
        <li class="accordion-navigation">
            <a href="#panel2a">Design chart</a>
            <div id="panel2a" class="content">

    @if($designchart)
    <?php $bodysass = 'body {
';
    $fontsass = '/* Fonts */

';
    $colorsass = '/* Colors */

';
    $titlesass = '/* Titles */

';
    $breakpointsass = '/* Breakpoints */

';
    $baseline = $designchart->font_size!=null ? $designchart->font_size : '16';
    $mixinsass = '/* Mixins */

$baseline-px: '.$baseline.'px;

@mixin rem($property, $px-values) {
    // Convert the baseline into rems
    $baseline-rem: $baseline-px / 1rem;
    // Print the first line in pixel values
    #{$property}: $px-values;
    // If there is only one (numeric) value, return the property/value line for it.
    @if type-of($px-values) == "number" {
        #{$property}: $px-values / $baseline-rem; }
    @else {
        // Create an empty list that we can dump values into
        $rem-values: unquote("");
        @each $value in $px-values {
            // If the value is zero, return 0
            @if $value == 0 {
                $rem-values: append($rem-values, $value); }
            @else {
                $rem-values: append($rem-values, $value / $baseline-rem); } }
        // Return the property and its list of converted values
        #{$property}: $rem-values; } }
// Usage
/*
p {
  @include rem(\'padding\', 14px);
}
*/
'; ?>
    <h4>Design chart</h4>
    @if($designchart->font_sans_serif != null || $designchart->font_size != null ||
        $designchart->font_serif != null || $designchart->line_height != null)
    <div class="row">
        <div class="large-12 columns">
            <h5><span class="fi-italic"></span> Fonts</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            @if($designchart->font_sans_serif != null)
                <?php $fontsass .= '$font-family-sans-serif: \''.$designchart->font_sans_serif.'\', sans-serif;
'; ?>
                Font Sans Serif: {{ $designchart->font_sans_serif }}<br/>
            @endif
            @if($designchart->font_size != null)
                <?php $bodysass .= '    @include rem(\'font-size\', '.$designchart->font_size.'px);
'; ?>
                Font size: {{ $designchart->font_size }}px<br/>
            @endif
        </div>
        <div class="large-6 medium-6 columns">
            @if($designchart->font_serif != null)
                <?php $fontsass .= '$font-family-serif: \''.$designchart->font_serif.'\', serif;
'; ?>
                Font Serif: {{ $designchart->font_serif }}<br/>
            @endif
            @if($designchart->line_height != null)
                <?php $bodysass .= '    @include rem(\'line-height\', '.$designchart->line_height.'px);
'; ?>
                Line height: {{ $designchart->line_height }}px<br/>
            @endif
        </div>
    </div>
    <br/>
    @endif
    @if($designchart->background_color != null || $designchart->primary_color != null || $designchart->secondary_color != null ||
        $designchart->info_color != null || $designchart->success_color != null ||
        $designchart->warning_color != null || $designchart->alert_color != null)
    <div class="row">
        <div class="large-12 columns">
            <h5><span class="fi-brush"></span> Colors</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-6 medium-6 columns">
            @if($designchart->background_color != null)
                <?php $bodysass .= '    background: #'.$designchart->background_color.';
'; ?>
                Background: <span class="label round" style="background-color:#{{ $designchart->background_color }};"><span class="invert-color-text">#{{ $designchart->background_color }}</span></span><br/>
            @endif
            @if($designchart->primary_color != null)
                <?php $colorsass .= '$primary-color: #'.$designchart->primary_color.';
'; ?>
                Primary: <span class="label round" style="background-color:#{{ $designchart->primary_color }};"><span class="invert-color-text">#{{ $designchart->primary_color }}</span></span><br/>
            @endif
            @if($designchart->secondary_color != null)
                <?php $colorsass .= '$secondary-color: #'.$designchart->secondary_color.';
'; ?>
                Secondary: <span class="label round" style="background-color:#{{ $designchart->secondary_color }};"><span class="invert-color-text">#{{ $designchart->secondary_color }}</span></span><br/>
            @endif
        </div>
        <div class="large-6 medium-6 columns">
            @if($designchart->info_color != null)
                <?php $colorsass .= '$info-color: #'.$designchart->info_color.';
'; ?>
                Info: <span class="label round" style="background-color:#{{ $designchart->info_color }};"><span class="invert-color-text">#{{ $designchart->info_color }}</span></span><br/>
            @endif
            @if($designchart->success_color != null)
                <?php $colorsass .= '$success-color: #'.$designchart->success_color.';
'; ?>
                Success: <span class="label round" style="background-color:#{{ $designchart->success_color }};"><span class="invert-color-text">#{{ $designchart->success_color }}</span></span><br/>
            @endif
            @if($designchart->warning_color != null)
                <?php $colorsass .= '$warning-color: #'.$designchart->warning_color.';
'; ?>
                Warning: <span class="label round" style="background-color:#{{ $designchart->warning_color }};"><span class="invert-color-text">#{{ $designchart->warning_color }}</span></span><br/>
            @endif
            @if($designchart->alert_color != null)
                <?php $colorsass .= '$alert-color: #'.$designchart->alert_color.';
'; ?>
                Alert: <span class="label round" style="background-color:#{{ $designchart->alert_color }};"><span class="invert-color-text">#{{ $designchart->alert_color }}</span></span><br/>
            @endif
        </div>
    </div>
    <br/>
    @endif
    @if($designchart->text_font != null || $designchart->text_color != null ||
        $designchart->text_font_size != null || $designchart->text_line_height != null)
        <?php $fontsass .= 'p {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h5><span class="fi-text"></span> Text</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->text_font != null)
                <?php $fontsass .= '    font-family: \''.$designchart->text_font.'\';
'; ?>
                Font: {{ $designchart->text_font }}<br/>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->text_color != null)
                <?php $fontsass .= '    color: #'.$designchart->text_color.';
'; ?>
                Color: <span class="label round" style="background-color:#{{ $designchart->text_color }};"><span class="invert-color-text">#{{ $designchart->text_color }}</span></span><br/>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->text_font_size != null)
                <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->text_font_size.'px);
'; ?>
                Font size: {{ $designchart->text_font_size }}px<br/>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->text_line_height != null)
                <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->text_line_height.'px);
'; ?>
                Line height: {{ $designchart->text_line_height }}px<br/>
            @endif
        </div>
    </div>
    <br/>
        <?php $fontsass .= '}
'; ?>
    @endif

    <?php $displayH1 = ($designchart->title_h1_font != null || $designchart->title_h1_color != null ||
                    $designchart->title_h1_font_size != null || $designchart->title_h1_line_height != null);
    $displayH2 = ($designchart->title_h2_font != null || $designchart->title_h2_color != null ||
            $designchart->title_h2_font_size != null || $designchart->title_h2_line_height != null);
    $displayH3 = ($designchart->title_h3_font != null || $designchart->title_h3_color != null ||
            $designchart->title_h3_font_size != null || $designchart->title_h3_line_height != null);
    $displayH4 = ($designchart->title_h4_font != null || $designchart->title_h4_color != null ||
            $designchart->title_h4_font_size != null || $designchart->title_h4_line_height != null);
    $displayH5 = ($designchart->title_h5_font != null || $designchart->title_h5_color != null ||
            $designchart->title_h5_font_size != null || $designchart->title_h5_line_height != null);
    $displayH6 = ($designchart->title_h6_font != null || $designchart->title_h6_color != null ||
            $designchart->title_h6_font_size != null || $designchart->title_h6_line_height != null);
            ?>
    @if($displayH1 || $displayH2 || $displayH3 || $displayH4 || $displayH5 || $displayH6)
    <div class="row">
        <div class="large-12 columns">
            <h5><span class="fi-bold"></span> Titles</h5>
        </div>
    </div>
    @if($displayH1)
        <?php $titlesass .= 'h1 {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h6>Title H1</h6>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h1_font != null)
                Font: {{ $designchart->title_h1_font }}<br/>
                <?php $titlesass .= '   font-family: \''.$designchart->title_h1_font.'\';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h1_color != null)
                Color: <span class="label round" style="background-color:#{{ $designchart->title_h1_color }};"><span class="invert-color-text">#{{ $designchart->title_h1_color }}</span></span><br/>
                <?php $titlesass .= '   color: #'.$designchart->title_h1_color.';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h1_font_size != null)
                Font size: {{ $designchart->title_h1_font_size }}px<br/>
                <?php $titlesass .= '   @include rem(\'font-size\', '.$designchart->title_h1_font_size.'px);
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h1_line_height != null)
                Line height: {{ $designchart->title_h1_line_height }}px<br/>
                <?php $titlesass .= '   @include rem(\'line-height\', '.$designchart->title_h1_line_height.'px);
'; ?>
            @endif
        </div>
    </div>
    <?php $titlesass .= '}
'; ?>
    @endif
    @if($displayH2)
        <?php $titlesass .= 'h2 {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h6>Title H2</h6>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h2_font != null)
                Font: {{ $designchart->title_h2_font }}<br/>
                <?php $titlesass .= '   font-family: \''.$designchart->title_h2_font.'\';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h2_color != null)
                Color: <span class="label round" style="background-color:#{{ $designchart->title_h2_color }};"><span class="invert-color-text">#{{ $designchart->title_h2_color }}</span></span><br/>
                <?php $titlesass .= '   color: #'.$designchart->title_h2_color.';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h2_font_size != null)
                Font size: {{ $designchart->title_h2_font_size }}px<br/>
                <?php $titlesass .= '   @include rem(\'font-size\', '.$designchart->title_h2_font_size.'px);
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h2_line_height != null)
                Line height: {{ $designchart->title_h2_line_height }}px<br/>
                <?php $titlesass .= '   @include rem(\'line-height\', '.$designchart->title_h2_line_height.'px);
'; ?>
            @endif
        </div>
    </div>
    <?php $titlesass .= '}
'; ?>
    @endif
    @if($displayH3)
        <?php $titlesass .= 'h3 {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h6>Title H3</h6>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h3_font != null)
                Font: {{ $designchart->title_h3_font }}<br/>
                <?php $titlesass .= '   font-family: \''.$designchart->title_h3_font.'\';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h3_color != null)
                Color: <span class="label round" style="background-color:#{{ $designchart->title_h3_color }};"><span class="invert-color-text">#{{ $designchart->title_h3_color }}</span></span><br/>
                <?php $titlesass .= '   color: #'.$designchart->title_h3_color.';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h3_font_size != null)
                Font size: {{ $designchart->title_h3_font_size }}px<br/>
                <?php $titlesass .= '   @include rem(\'font-size\', '.$designchart->title_h3_font_size.'px);
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h3_line_height != null)
                Line height: {{ $designchart->title_h3_line_height }}px<br/>
                <?php $titlesass .= '   @include rem(\'line-height\', '.$designchart->title_h3_line_height.'px);
'; ?>
            @endif
        </div>
    </div>
    <?php $titlesass .= '}
'; ?>
    @endif
    @if($displayH4)
        <?php $titlesass .= 'h4 {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h6>Title H4</h6>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h4_font != null)
                Font: {{ $designchart->title_h4_font }}<br/>
                <?php $titlesass .= '   font-family: \''.$designchart->title_h4_font.'\';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h4_color != null)
                Color: <span class="label round" style="background-color:#{{ $designchart->title_h4_color }};"><span class="invert-color-text">#{{ $designchart->title_h4_color }}</span></span><br/>
                <?php $titlesass .= '   color: #'.$designchart->title_h4_color.';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h4_font_size != null)
                Font size: {{ $designchart->title_h4_font_size }}px<br/>
                <?php $titlesass .= '   @include rem(\'font-size\', '.$designchart->title_h4_font_size.'px);
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h4_line_height != null)
                Line height: {{ $designchart->title_h4_line_height }}px<br/>
                <?php $titlesass .= '   @include rem(\'line-height\', '.$designchart->title_h4_line_height.'px);
'; ?>
            @endif
        </div>
    </div>
    <?php $titlesass .= '}
'; ?>
    @endif
    @if($displayH5)
        <?php $titlesass .= 'h5 {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h6>Title H5</h6>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h5_font != null)
                Font: {{ $designchart->title_h5_font }}<br/>
                <?php $titlesass .= '   font-family: \''.$designchart->title_h5_font.'\';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h5_color != null)
                Color: <span class="label round" style="background-color:#{{ $designchart->title_h5_color }};"><span class="invert-color-text">#{{ $designchart->title_h5_color }}</span></span><br/>
                <?php $titlesass .= '   color: #'.$designchart->title_h5_color.';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h5_font_size != null)
                Font size: {{ $designchart->title_h5_font_size }}px<br/>
                <?php $titlesass .= '   @include rem(\'font-size\', '.$designchart->title_h5_font_size.'px);
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h5_line_height != null)
                Line height: {{ $designchart->title_h5_line_height }}px<br/>
                <?php $titlesass .= '   @include rem(\'line-height\', '.$designchart->title_h5_line_height.'px);
'; ?>
            @endif
        </div>
    </div>
    <?php $titlesass .= '}
'; ?>
    @endif
    @if($displayH6)
        <?php $titlesass .= 'h6 {
'; ?>
    <div class="row">
        <div class="large-12 columns">
            <h6>Title H6</h6>
        </div>
    </div>
    <div class="row">
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h6_font != null)
                Font: {{ $designchart->title_h6_font }}<br/>
                <?php $titlesass .= '   font-family: \''.$designchart->title_h6_font.'\';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h6_color != null)
                Color: <span class="label round" style="background-color:#{{ $designchart->title_h6_color }};"><span class="invert-color-text">#{{ $designchart->title_h6_color }}</span></span><br/>
                <?php $titlesass .= '   color: #'.$designchart->title_h6_color.';
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h6_font_size != null)
                Font size: {{ $designchart->title_h6_font_size }}px<br/>
                <?php $titlesass .= '   @include rem(\'font-size\', '.$designchart->title_h6_font_size.'px);
'; ?>
            @endif
        </div>
        <div class="large-3 medium-3 columns">
            @if($designchart->title_h6_line_height != null)
                Line height: {{ $designchart->title_h6_line_height }}px<br/>
                <?php $titlesass .= '   @include rem(\'line-height\', '.$designchart->title_h6_line_height.'px);
'; ?>
            @endif
        </div>
    </div>
    <?php $titlesass .= '}
'; ?>
    @endif
    <br/>
    @endif
    <div class="row">
        <div class="large-12 columns">
            <h5><span class="fi-laptop"></span> Breakpoints</h5>
        </div>
    </div>
    <div class="row breakpoints-info">
        <div class="large-2 medium-3 columns">
            @if($designchart->breakpoint_mobile != null)
                <?php $breakpointsass .= '@mixin bp-large {
    @media only screen and (max-width: '.$designchart->breakpoint_mobile.'px) {
        @content;
    }
}
'; ?>
                <span class="fi-nexus iconic-size-md"></span> {{ $designchart->breakpoint_mobile }}px
            @endif
        </div>
        <div class="large-2 medium-3 columns">
            @if($designchart->breakpoint_tablet != null)
                <?php $breakpointsass .= '@mixin bp-medium {
    @media only screen and (max-width: '.$designchart->breakpoint_tablet.'px) {
        @content;
    }
}
'; ?>
                <span class="fi-tablet iconic-size-md"></span> {{ $designchart->breakpoint_tablet }}px
            @endif
        </div>
        <div class="large-2 medium-3 columns">
            @if($designchart->breakpoint_desktop != null)
                <?php $breakpointsass .= '@mixin bp-small {
    @media only screen and (max-width: '.$designchart->breakpoint_desktop.'px) {
        @content;
    }
}
'; ?>
                <span class="fi-monitor iconic-size-md"></span>{{ $designchart->breakpoint_desktop }}px
            @endif
        </div>
        <div class="large-6 medium-3 columns">
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="large-12 columns">
            <h4><span class="fi-code"></span> SASS code</h4>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <pre>
                <?php $bodysass .= '}
'; ?>
                <code data-language="css">
{{ $bodysass }}
{{ $colorsass }}
{{ $fontsass }}
{{ $titlesass }}
{{ $breakpointsass }}
{{ $mixinsass }}</code>
            </pre>
        </div>
    </div>
            </div>
        </li>
    </ul>
    @endif
    <h4>Other actions</h4>
    @if(\Auth::user()->hasRight(\App\Right::PROJECT_MODIFY))
        <a class="button tiny round left" href="{{ route('project.edit', $project->id) }}"><span class="fi-pencil" title="edit" aria-hidden="true"></span> Edit project</a>
    @endif
    @if(\Auth::user()->hasRight(\App\Right::PROJECT_DELETE))
        <a class="button tiny round alert deleteEl"
           data-route="{{ route('project.destroy', $project->id) }}"
           data-redirect="{{ route('client.show', $project->client->id) }}"
           data-token="{{ csrf_token() }}"
            data-type="project"><span class="fi-delete" title="delete" aria-hidden="true"></span> Delete project</a>
    @endif
@stop