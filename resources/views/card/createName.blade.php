<x-app-layout>
    <x-slot name="header">


        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة اسماء ' ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">




                <div style="clear: both;"></div>
                <form method="post" action="{{route('addName')}}">
                    @csrf
                    <div class="form-group">
                        <label >رقم البطاقة</label>
                        <input type="number" class="form-control" name="barcode" placeholder="باركود" required min="1"
                               autofocus>

                        <ul class="errors">
                            @foreach ($errors->get('barcode') as $message)
                                <i>{{ $message }}</i>
                            @endforeach
                        </ul>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-group">
                        <label >الاسم</label>
                        <input type="text" class="form-control" name="name" placeholder="الاسم" required min="1"
                               autofocus>

                        <ul class="errors">
                            @foreach ($errors->get('name') as $message)
                                <i>{{ $message }}</i>
                            @endforeach
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-primary">إضافة</button>

                </form>




            </div>
        </div>
    </div>


</x-app-layout>
