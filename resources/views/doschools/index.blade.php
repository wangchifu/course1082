@extends('layouts.master',['bg_color'=>'bg-dark'])

@section('title',' 普教審查 | ')

@section('content')
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <table>
                        <tr>
                            <td>
                                <img src="{{ asset('images/check.svg') }}" height="24">
                            </td>
                            <td>
                                選擇年度：
                            </td>
                            <td>
                                {{ Form::open(['route'=>'doschool.index','method'=>'post']) }}
                                {{ Form::select('year',$year_items,$select_year,['onchange'=>'submit()']) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <table border="1" width="100%" class="table-striped">
                        <thead>
                        <tr>
                            <th nowrap style="background-color: #c4e1ff">
                                校名
                            </th>
                            <th nowrap>
                                評審<br>委員
                            </th>
                            <th nowrap style="background-color:#fff8d7">
                                評審<br>狀況
                            </th>
                            @foreach($special_questions as $special_question)
                                <th>
                                    特{{ $special_question->order_by }}：
                                    <!--
                                        {{ $special_question->title }}
                                    -->
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td nowrap>
                                    {{ $schools[$course->school_code] }} <small>({{ $course->school_code }})</small>
                                </td>
                                <td>
                                    {{ $first_name[$course->school_code] }}
                                </td>
                                <td>
                                    @if($course->first_result1==null)
                                        <span class="text-dark">未送審</span>
                                    @endif
                                    @if($course->first_result1=='late')
                                        <span class="text-warning">未交</span>
                                    @endif
                                    @if($course->first_result1=="submit")
                                        <span class="text-primary">已送審</span>
                                    @endif
                                    @if($course->first_result1=="ok")
                                        <span class="text-primary">已通過</span>
                                    @endif
                                    @if($course->first_result1=="back")
                                        <span class="text-danger">被退回</span>
                                    @endif
                                    @if($course->first_result1=="excellent")
                                        <span class="text-success">進入複審</span>
                                    @endif
                                </td>
                                @foreach($special_questions as $special_question)
                                    <td>
                                        @if(isset($s_r[$course->school_code][$special_question->id]))
                                            {{ $s_r[$course->school_code][$special_question->id] }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{ $courses->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
