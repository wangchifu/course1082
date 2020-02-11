@extends('layouts.master_clean')
@section('title','全部審查結果 | ')
@section('content')
    <h1>
    {{ $select_year }}{{ auth()->user()->school }}：全部課程審查
    </h1>
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>
                審核
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                結果：
                @if($course->first_result1==null)
                    <span class="text-warning">未送審</span>
                @endif
                @if($course->first_result1=="submit")
                    <span>已送審</span>
                @endif
                @if($course->first_result1=="ok")
                    <span class="text-info">已通過</span>
                @endif
                @if($course->first_result1=="back")
                    <span class="text-danger">被退回</span>
                @endif
                @if($course->first_result1=="excellent1")
                    <span class="text-success">優良(特優)</span>
                @elseif($course->first_result1=="excellent2")
                    <span class="text-success">優良(優等)</span>
                @elseif($course->first_result1=="excellent3")
                    <span class="text-success">優良(甲等)</span>
                @endif
                <br>
                @if($course->first_reason1)
                評審意見：<br>
                <span class="text-primary">
                    {!! nl2br($course->first_reason1) !!}
                </span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>
<table class="table table-striped">
    <thead class="thead-light">
    <tr>
        <th nowrap>
            題號
        </th>
        <th nowrap>
            題目
        </th>
        <th nowrap>
            必填?
        </th>
        <th nowrap>
            繳交?
        </th>
        <th width="10%" nowrap>
            符合?
        </th>
        <th width="30%" nowrap>
            逐項建議
        </th>
    </tr>
    </thead>
    <tbody>
        @foreach($questions as $question)
            <?php
                if($question->g_s=="1"){
                    $suggest1 = \App\FirstSuggest1::where('school_code',auth()->user()->code)
                        ->where('question_id',$question->id)
                        ->first();
                    $suggest2 = \App\FirstSuggest2::where('school_code',auth()->user()->code)
                        ->where('question_id',$question->id)
                        ->first();
                    $suggest3 = \App\FirstSuggest3::where('school_code',auth()->user()->code)
                        ->where('question_id',$question->id)
                        ->first();
                }
                if($question->g_s=="2"){
                    $special_suggest = \App\SpecialSuggest::where('school_code',auth()->user()->code)
                        ->where('question_id',$question->id)
                        ->first();
                }
            ?>
            @if($question->g_s=="1")
            <tr>
                <td>
                    {{ $question->order_by }}
                </td>
                <td>
                    {{ $question->title }}
                </td>
                <td nowrap>
                    @if($question->need==1)
                        <span class="text-primary">必填</span>
                    @elseif($question->need==0 and $question->type != 0)
                        <span class="text-warning">非必填</span>
                    @endif
                    @if($question->type==0)
                        <span class="text-secondary">不用傳</span>
                    @endif
                </td>
                <td>
                    <?php
                        $upload = \App\Upload::where('question_id',$question->id)
                            ->where('code',$course->school_code)
                            ->first();
                    ?>
                    @if($upload)
                        <span class="text-success">已送</span>
                    @else
                        @if($question->type != 0)
                        <span class="text-warning">未送</span>
                        @endif
                    @endif
                </td>
                <td nowrap>
                    @if($question->type != 0)
                        @if($suggest1)
                            @if($suggest1->pass=="1")
                                審核：<br>
                                <span class="text-success">符合！</span>
                            @endif
                            @if($suggest1->pass=="0")
                                    審核：<br>
                                <span class="text-danger">不符合！</span>
                            @endif
                        @else
                            審核：<br>
                            <span class="text-warning">未審！</span>
                        @endif
                    @endif
                </td>
                <td>
                    @if($question->type != 0)
                        @if($suggest1)
                            @if($suggest1->suggest)
                            審核：<br>
                            <span class="text-primary">
                                {!! nl2br($suggest1->suggest) !!}
                            </span>
                            @endif
                        @endif
                        <br>
                    @endif
                </td>
            </tr>
            @endif
            @if($question->g_s=="2")
                <tr>
                    <td>
                        {{ $question->order_by }}
                    </td>
                    <td>
                        {{ $question->title }}
                    </td>
                    <td>
                        @if($question->need==1)
                            <span class="text-primary">必填</span>
                        @elseif($question->need==0 and $question->type != 0)
                            <span class="text-warning">非必填</span>
                        @endif
                        @if($question->type==0)
                            <span class="text-secondary">不用傳</span>
                        @endif
                    </td>
                    <td>
                        <?php
                        $upload = \App\Upload::where('question_id',$question->id)
                            ->where('code',$course->school_code)
                            ->first();
                        ?>
                        @if($upload)
                            <span class="text-success">已送</span>
                        @else
                            @if($question->type != 0)
                                <span class="text-warning">未送</span>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($special_suggest)
                            @if($special_suggest->pass=="1")
                                <span class="text-success">符合！</span>
                            @endif
                            @if($special_suggest->pass=="0")
                                <span class="text-danger">不符合！</span>
                            @endif
                        @else
                            <span class="text-warning">未審</span>
                        @endif
                    </td>
                    <td>
                        @if($special_suggest)
                            <span class="text-primary">
                                {!! nl2br($special_suggest->suggest) !!}
                            </span>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
@endsection
