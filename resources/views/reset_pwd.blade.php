@extends('layouts.master',['bg_color'=>'bg-dark'])

@section('title','更改密碼 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <img src="{{ asset('images/key.svg') }}" height="24">
                        變更密碼
                    </h5>
                </div>
                <div class="card-body">
                    @include('layouts.form_errors')
                    @if(auth()->user()->login_type=='local')
                        <form action="{{ route('update_pwd') }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="exampleInputPassword0">舊密碼*</label>
                                <input type="password" class="form-control" name="password0" id="exampleInputPassword0" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">新密碼*</label>
                                <input type="password" class="form-control" name="password1" id="exampleInputPassword1" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">確認新密碼*</label>
                                <input type="password" class="form-control" name="password2" id="exampleInputPassword2" required>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="return confirm('確定嗎？')">送出</button>
                        </form>
                    @elseif(auth()->user()->login_type=='gsuite')
                        使用GSuite登入，請更改OpenID密碼，登入後即更改本站密碼。
                    @endif
                    <?php
                    $special_questions_id_array = \App\Question::where('year','109')->where('g_s','2')->pluck('id')->toArray();
                    $schools = config('course.schools');
                    foreach($schools as $k=>$v){
                        $check_pass = \App\SpecialSuggest::whereIn('question_id',$special_questions_id_array)->where('pass','0')->where('school_code',$k)->count();
                        if($check_pass>0){
                            $course = \App\Course::where('year','109')->where('school_code',$k)->first();
                            $att['special_result'] ="back";
                            $course->update($att);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
@endsection
