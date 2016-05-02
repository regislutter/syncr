@extends('layouts.master')

@section('title', 'Project: ' . $project->name)

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

    <ul class="accordion" data-accordion>
        <li class="accordion-navigation">
            <a href="#panel3a">Copydecks</a>
            <div id="panel3a" class="content">
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
            </div>
        </li>

        <li class="accordion-navigation">
            <a href="#panel4a">Tickets</a>
            <div id="panel4a" class="content">
                <h4>Tickets</h4>
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Estimate</th>
                        <th>Date start</th>
                        <th>Deadline</th>
                        <th>User</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($project->tickets as $ticket)
                        <tr>
                            <td><a href="{{ route('ticket.show', $ticket->id) }}">{{ $ticket->name }}</a></td>
                            <td>{{ $ticket->getCategory() }}</td>
                            <td>{{ $ticket->getStatus() }}</td>
                            <td>{{ $ticket->getPriority() }}</td>
                            <td>{{ $ticket->getEstimate() }}</td>
                            <td>{{ $ticket->getDateStart() }}</td>
                            <td>{{ $ticket->getDateEnd() }}</td>
                            <td><a href="{{ route('user.show', [$ticket->user->id]) }}">{{ $ticket->user->name }}</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                No tickets yet.<br/>
                                @if(\Auth::user()->hasRight(\App\Right::TICKET_CREATE))
                                    <a class="button tiny round left" href="{{ route('ticket.create') }}"><span class="fi-plus" title="create" aria-hidden="true"></span> Create new ticket</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </li>

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
            <h5><span class="fi-italic"></span> Default fonts</h5>
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

        <?php
            function getContrastYIQ($hexcolor){
                $r = hexdec(substr($hexcolor,0,2));
                $g = hexdec(substr($hexcolor,2,2));
                $b = hexdec(substr($hexcolor,4,2));
                $yiq = (($r*299)+($g*587)+($b*114))/1000;
                return ($yiq >= 128) ? ' text-black' : ' text-white';
            }
        ?>

        <div class="row">
            <div class="large-1 columns color-chart">
                @if($designchart->background_color != null)
                    <?php $bodysass .= '    background: #'.$designchart->background_color.';
'; ?>
                    Background<br/><span class="color-chart-info{{ getContrastYIQ($designchart->background_color) }}" style="background-color:#{{ $designchart->background_color }};">#{{ $designchart->background_color }}</span><br/>
                    @else
                    Empty
                @endif
            </div>
            <div class="large-1 columns color-chart">
                @if($designchart->primary_color != null)
                    <?php $colorsass .= '$primary-color: #'.$designchart->primary_color.';
'; ?>
                    Primary<br/><span class="color-chart-info{{ getContrastYIQ($designchart->primary_color) }}" style="background-color:#{{ $designchart->primary_color }};">#{{ $designchart->primary_color }}</span><br/>
                @else
                    Empty
                @endif
            </div>
            <div class="large-1 columns color-chart">
                @if($designchart->secondary_color != null)
                    <?php $colorsass .= '$secondary-color: #'.$designchart->secondary_color.';
'; ?>
                        Secondary<br/><span class="color-chart-info{{ getContrastYIQ($designchart->secondary_color) }}" style="background-color:#{{ $designchart->secondary_color }};">#{{ $designchart->secondary_color }}</span><br/>
                @else
                    Empty
                @endif
            </div>
            <div class="large-1 columns color-chart">
                @if($designchart->info_color != null)
                    <?php $colorsass .= '$info-color: #'.$designchart->info_color.';
'; ?>
                        Info<br/><span class="color-chart-info{{ getContrastYIQ($designchart->info_color) }}" style="background-color:#{{ $designchart->info_color }};">#{{ $designchart->info_color }}</span><br/>
                @else
                    Empty
                @endif
            </div>
            <div class="large-1 columns color-chart">
                @if($designchart->success_color != null)
                    <?php $colorsass .= '$success-color: #'.$designchart->success_color.';
'; ?>
                        Success<br/><span class="color-chart-info{{ getContrastYIQ($designchart->success_color) }}" style="background-color:#{{ $designchart->success_color }};">#{{ $designchart->success_color }}</span><br/>
                @else
                    Empty
                @endif
            </div>
            <div class="large-1 columns color-chart">
                @if($designchart->warning_color != null)
                    <?php $colorsass .= '$warning-color: #'.$designchart->warning_color.';
'; ?>
                        Warning<br/><span class="color-chart-info{{ getContrastYIQ($designchart->warning_color) }}" style="background-color:#{{ $designchart->warning_color }};">#{{ $designchart->warning_color }}</span><br/>
                @else
                    Empty
                @endif
            </div>
            <div class="large-1 columns color-chart">
                @if($designchart->alert_color != null)
                    <?php $colorsass .= '$alert-color: #'.$designchart->alert_color.';
'; ?>
                    Alert<br/><span class="color-chart-info{{ getContrastYIQ($designchart->alert_color) }}" style="background-color:#{{ $designchart->alert_color }};">#{{ $designchart->alert_color }}</span><br/>
                @else
                    Empty
                @endif
            </div>
            <div class="large-5 columns"></div>
        </div>

    <br/>
    @endif

    <?php $globalText = ($designchart->text_font != null || $designchart->text_color != null ||
                $designchart->text_font_size != null || $designchart->text_line_height != null);
        $displayH1 = ($designchart->title_h1_font != null || $designchart->title_h1_color != null ||
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

    @if($globalText || $displayH1 || $displayH2 || $displayH3 || $displayH4 || $displayH5 || $displayH6)
        <div style="font-family: '{{ $designchart->font_sans_serif }}'; line-height: {{ $designchart->line_height }}px; font-size: {{ $designchart->font_size }}px;">
    <div class="row">
        <div class="large-12 columns">
            <h5><span class="fi-text"></span> Texts</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($globalText)
                <?php $fontsass .= 'p {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->text_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->text_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: #'.$designchart->text_font.';'; ?>
                    <?php $text .= 'Font: '.$designchart->text_font.'; ' ?>
                @endif
                @if($designchart->text_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->text_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: #'.$designchart->text_font_size.';'; ?>
                    <?php $text .= 'Font size: '.$designchart->text_font_size.'; ' ?>
                @endif
                @if($designchart->text_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->text_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: #'.$designchart->text_line_height.';'; ?>
                    <?php $text .= 'Line height: '.$designchart->text_line_height.'; ' ?>
                @endif
                @if($designchart->text_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->text_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->text_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->text_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>
                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a paragraph</span>
                {{--P: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($displayH1)
                <?php $fontsass .= 'h1 {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->title_h1_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->title_h1_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: \''.$designchart->title_h1_font.'\';'; ?>
                    <?php $text .= 'Font: '.$designchart->title_h1_font.'; ' ?>
                @endif
                @if($designchart->title_h1_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->title_h1_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: '.$designchart->title_h1_font_size.'px;'; ?>
                    <?php $text .= 'Font size: '.$designchart->title_h1_font_size.'px; ' ?>
                @endif
                @if($designchart->title_h1_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->title_h1_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: '.$designchart->title_h1_line_height.'px;'; ?>
                    <?php $text .= 'Line height: '.$designchart->title_h1_line_height.'px; ' ?>
                @endif
                @if($designchart->title_h1_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->title_h1_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->title_h1_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->title_h1_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>

                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a title H1</span>
                {{--H1: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($displayH2)
                <?php $fontsass .= 'h2 {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->title_h2_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->title_h2_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: \''.$designchart->title_h2_font.'\';'; ?>
                    <?php $text .= 'Font: '.$designchart->title_h2_font.'<br/>' ?>
                @endif
                @if($designchart->title_h2_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->title_h2_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: '.$designchart->title_h2_font_size.'px;'; ?>
                    <?php $text .= 'Font size: '.$designchart->title_h2_font_size.'px<br/>' ?>
                @endif
                @if($designchart->title_h2_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->title_h2_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: '.$designchart->title_h2_line_height.'px;'; ?>
                    <?php $text .= 'Line height: '.$designchart->title_h2_line_height.'px<br/>' ?>
                @endif
                @if($designchart->title_h2_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->title_h2_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->title_h2_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->title_h2_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>

                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a title H2</span>
                {{--H2: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($displayH3)
                <?php $fontsass .= 'h3 {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->title_h3_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->title_h3_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: \''.$designchart->title_h3_font.'\';'; ?>
                    <?php $text .= 'Font: '.$designchart->title_h3_font.'<br/>' ?>
                @endif
                @if($designchart->title_h3_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->title_h3_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: '.$designchart->title_h3_font_size.'px;'; ?>
                    <?php $text .= 'Font size: '.$designchart->title_h3_font_size.'px<br/>' ?>
                @endif
                @if($designchart->title_h3_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->title_h3_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: '.$designchart->title_h3_line_height.'px;'; ?>
                    <?php $text .= 'Line height: '.$designchart->title_h3_line_height.'px<br/>' ?>
                @endif
                @if($designchart->title_h3_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->title_h3_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->title_h3_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->title_h3_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>

                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a title H3</span>
                {{--H3: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($displayH4)
                <?php $fontsass .= 'h4 {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->title_h4_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->title_h4_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: \''.$designchart->title_h4_font.'\';'; ?>
                    <?php $text .= 'Font: '.$designchart->title_h4_font.'<br/>' ?>
                @endif
                @if($designchart->title_h4_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->title_h4_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: '.$designchart->title_h4_font_size.'px;'; ?>
                    <?php $text .= 'Font size: '.$designchart->title_h4_font_size.'px<br/>' ?>
                @endif
                @if($designchart->title_h4_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->title_h4_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: '.$designchart->title_h4_line_height.'px;'; ?>
                    <?php $text .= 'Line height: '.$designchart->title_h4_line_height.'px<br/>' ?>
                @endif
                @if($designchart->title_h4_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->title_h4_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->title_h4_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->title_h4_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>

                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a title H4</span>
                {{--H4: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($displayH5)
                <?php $fontsass .= 'h5 {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->title_h5_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->title_h5_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: \''.$designchart->title_h5_font.'\';'; ?>
                    <?php $text .= 'Font: '.$designchart->title_h5_font.'<br/>' ?>
                @endif
                @if($designchart->title_h5_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->title_h5_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: '.$designchart->title_h5_font_size.'px;'; ?>
                    <?php $text .= 'Font size: '.$designchart->title_h5_font_size.'px<br/>' ?>
                @endif
                @if($designchart->title_h5_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->title_h5_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: '.$designchart->title_h5_line_height.'px;'; ?>
                    <?php $text .= 'Line height: '.$designchart->title_h5_line_height.'px<br/>' ?>
                @endif
                @if($designchart->title_h5_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->title_h5_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->title_h5_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->title_h5_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>

                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a title H5</span>
                {{--H5: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns text-chart">
            @if($displayH6)
                <?php $fontsass .= 'h6 {
'; ?>
                <?php $text = ''; $fontcss = 'background-color:'.$designchart->background_color.';'; ?>
                @if($designchart->title_h6_font != null)
                    <?php $fontsass .= '    font-family: \''.$designchart->title_h6_font.'\';
'; ?>
                    <?php $fontcss .= 'font-family: \''.$designchart->title_h6_font.'\';'; ?>
                    <?php $text .= 'Font: '.$designchart->title_h6_font.'<br/>' ?>
                @endif
                @if($designchart->title_h6_font_size != null)
                    <?php $fontsass .= '    @include rem(\'font-size\', '.$designchart->title_h6_font_size.'px);
'; ?>
                    <?php $fontcss .= 'font-size: '.$designchart->title_h6_font_size.'px;'; ?>
                    <?php $text .= 'Font size: '.$designchart->title_h6_font_size.'px<br/>' ?>
                @endif
                @if($designchart->title_h6_line_height != null)
                    <?php $fontsass .= '    @include rem(\'line-height\', '.$designchart->title_h6_line_height.'px);
'; ?>
                    <?php $fontcss .= 'line-height: '.$designchart->title_h6_line_height.'px;'; ?>
                    <?php $text .= 'Line height: '.$designchart->title_h6_line_height.'px<br/>' ?>
                @endif
                @if($designchart->title_h6_color != null)
                    <?php $fontsass .= '    color: #'.$designchart->title_h6_color.';
'; ?>
                    <?php $fontcss .= 'color: #'.$designchart->title_h6_color.';'; ?>
                    <?php $text .= 'Color: #'.$designchart->title_h6_color ?>
                @endif
                    <?php $fontsass .= '}
'; ?>

                <span class="text-chart-info" style="{{ $fontcss }}">Example of text in a title H6</span>
                {{--H6: {!! $text !!}--}}
            @else
                Empty
            @endif
        </div>
    </div>
        </div>

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