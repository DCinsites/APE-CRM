<?php $parent_task = $rec->parent_task()->get()->first();?>
@if($parent_task)
    <hr>
    <small><b>@lang('form.parent_task')</b></small>
    <ul style="list-style-type: none; padding-left: 0!important; font-size: 13px;">
        <li><a href="{{ route('show_task_page', $parent_task->id) }}">{{ $parent_task->title }}</a> {{ $parent_task->status->name }}</li>
    </ul>  
    <br>
@endif