@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @php( $page = 'writers' )
            @include('admin.layouts.sidebar')
            <div class="col-sm-9">
                @include('admin.layouts.message')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        تعديل كاتب
                        <a href="{{ route('writers.destroy', $writer->id) }}" class="btn btn-danger btn-xs pull-left">حذف</a>
                    </div>

                    <div class="panel-body">
                        <div class="alert alert-warning">
                            <p><strong>ملاحظة: </strong>عند ترك الصورة او كلمة المرور فارغة لا يتم تغيير السابقة.</p>
                        </div>
                        <div class="alert alert-danger">
                            <p><strong>ملاحظة: </strong>عند حذف كاتب يتم مسح جميع اخباره ومقالاته ولا يمكن استرجاعها.</p>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('writers.update', $writer->id) }}" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        @if ( $writer->image_id )
                                            <img src="{{ asset('storage/writers/'.$writer->image()->first()->filename) }}" alt="{{ $writer->image()->first()->filename }}">
                                        @else
                                            <img src="{{ asset($path.'writers/default.png') }}" alt="'default.png'">
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}" style="margin-bottom: 15px;">
                                        <div class="col-md-12">
                                            <input id="image" type="file" class="form-control inputfile" name="image" value="{{ old('image') }}">
                                            <label for="image"><span>الصورة</span></label>
                                            @if ($errors->has('image'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input placeholder="الاسم" id="name" type="text" class="form-control" name="name" value="{{ old('name', $writer->name) }}">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input placeholder="البريد" id="email" type="text" class="form-control" name="email" value="{{ old('email', $writer->email) }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input placeholder="كلمة المرور" id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="تأكيد كلمة المرور" id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <textarea id="bio" placeholder="نبذة" class="form-control" name="bio" rows="8" cols="80">{{ old('bio', $writer->bio) }}</textarea>
                                            @if ($errors->has('bio'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('bio') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>يكتب : </label>
                                            <div class="checkbox">
                                                <input id="add_news" type="checkbox" name="add_news" {{ old('add_news', $writer->add_news) ? 'checked' : '' }}>
                                                <label for="add_news" class="mark">أخبار</label>
                                            </div>

                                            <div class="checkbox">
                                                <input id="add_essays" type="checkbox" name="add_essays" {{ old('add_essays', $writer->add_essays) ? 'checked' : '' }}>
                                                <label for="add_essays" class="mark">مقالات</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>في : </label>
                                            @foreach ( $categories as $category )
                                                <div class="checkbox">
                                                    <input id="category_{{ $category->id }}" type="checkbox" name="category_{{ $category->id }}" {{ old('category_'.$category->id) ? 'checked' : '' }} {{ in_array($category->id, $writerCategories) ? 'checked' : '' }}>
                                                    <label for="category_{{ $category->id }}" class="mark">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-default btn-block">
                                                تعديل
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
