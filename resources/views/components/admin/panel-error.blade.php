    {{--Hiển thị lỗi khi validate không thành công --}}
    @if($errors->any())
        <p class="alert alert-danger">
            @foreach($errors->all() as $e)
            {{$e }} <br>
            @endforeach
        </p>
    @endif

    {{-- Hiển thị thực hiện insert thất bại
    Đọc session flash --}}
    @if(session('message'))
    <p class="alert alert-danger">{{ session('message') }}</p>
    @endif