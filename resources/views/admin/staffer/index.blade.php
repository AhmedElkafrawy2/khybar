@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @php( $page = 'staffer' )
        @include('admin.layouts.sidebar')

        <div class="col-sm-9">
            @include('admin.layouts.message')
            <div class="panel panel-default">
                <div class="panel-heading">
                    اعضاء هيئة التحرير- {{ count( $staffer )  }}
                    <a href="{{ route('staffer.create') }}" class="btn btn-info btn-xs pull-left">إضافة</a>
                </div>
                @if ( count( $staffer ) == 0 )
                    <div class="panel-body">
                        <div class="alert alert-info" style="margin-bottom: 0px;">
                            <p>قائمة اعضاء هيئة التحرير فارغة</p>
                        </div>
                    </div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الوظيفة</th>
                                <th>الصورة</th>
                                <th>تعديل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $staffer as $essay )
                                <tr>
                                    <td>{{ $essay->name }}</td>
                                    <td>{{ $essay->job_title }}</td>
                                    <td>
                                        <img 
                                             src="{{ url("/storage/app/public/") . "/staffer/" . $essay->image()->first()->filename }}"
                                             alt="{{ url("/storage/app/public/") . "/staffer/" . $essay->image()->first()->filename }}"
                                             style="width: 60px;height: 60px;"/>
                                        
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ route('staffer.edit', $essay->id) }}">تعديل</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

           {{ $staffer->links() }}
        </div>
    </div>
</div>
@endsection
