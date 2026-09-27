@if (auth()->user()->type === 'admin')

    @section('adminContent')
         @include('admin.partials.student')
    @endsection
    
@elseif(auth()->user()->type === 'staff')
    @section('staffContent')
        @include('admin.partials.student')
    @endsection

@endif