<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 float-right">
            {{ __('معلومات عن الكروت' ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">


                <div class="row">
                    <div class="col">
                        <h3>الاضافات</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">باركود</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">مجموع الإضافات</th>
                                <th scope="col">قيمة البطاقة الحالية</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($card_withdraw as $cardW)
                                <tr>
                                    <td>{{$cardW->barcode}}</td>
                                    <td>{{$cardW->card->name}}</td>
                                    <td>{{$cardW->sum}} ل.س</td>
                                    <td>{{$cardW->card->balance}} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="col">
                        <h3>الخصومات</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">باركود</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">مجموع الخصومات</th>
                                <th scope="col">قيمة البطاقة الحالية</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($card_deposit as $cardD)
                                <tr>
                                    <td>{{$cardD->barcode}}</td>
                                    <td>{{$cardD->card->name}}</td>
                                    <td>-{{$cardD->sum}} ل.س</td>
                                    <td>{{$cardD->card->balance}} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>


            </div>
        </div>
    </div>


</x-app-layout>
