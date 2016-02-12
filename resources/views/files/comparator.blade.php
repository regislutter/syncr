@extends('layouts.master')

@section('title', 'Compare document versions')

@section('content')
    <h1>Compare document versions</h1>
    <h2>{{ $file1->copydeck->name }} - {{ $file1->version }} to {{ $file2->version }}</h2>
    <div id="comparator"></div>
    <div id="content1" style="display:none;">{!! nl2br($file1->content) !!}</div>
    <div id="content2" style="display:none;">{!! nl2br($file2->content) !!}</div>

    @if($file1->content && $file2->content)
        {!! HTML::script('js/jsdiff/diff.min.js') !!}
        <script type="text/javascript">
            String.prototype.replaceAll = function(search, replacement) {
                var target = this;
                return target.replace(new RegExp(search, 'g'), replacement);
            };

            function strip(html)
            {
                var tmp = document.createElement("div");
                html = html.replaceAll('<br/>', '\n');
                tmp.innerHTML = html.replaceAll('<br>', '\n');
                return tmp.textContent || tmp.innerText || "";
            }

            /* Comparator */
            var options = {};
            var content1 = strip(document.getElementById('content1').innerHTML);
            var content2 = strip(document.getElementById('content2').innerHTML);
            var diffVersions = JsDiff.diffChars(content1, content2);

            var display = document.getElementById('comparator');
            diffVersions.forEach(function(part){
                var counter = 0;
                // green for additions, red for deletions
                // grey for common parts
                var color = part.added ? 'white' :
                        part.removed ? 'white' : 'grey';
                var back = part.added ? 'green' :
                        part.removed ? 'red' : 'transparent';
                var span = document.createElement('span');
                span.style.color = color;
                span.style.backgroundColor = back;
                var listLines = part.value.split(/\n/g);
                listLines.forEach(function(line){
                    span.appendChild(document.createTextNode(line));
                    if(counter != 0 && counter != listLines.length-1){
                        span.appendChild(document.createElement('br'));
                    }
                    counter++;
                });
                display.appendChild(span);
            });
        </script>
    @endif
@stop