<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('معلومات عن البطاقات' ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">

                <div class="row">
                    <div class="col">
                        <div class="card bg-danger" style="color: #fff">
                            <div class="card-header">
                                مجموع الحسومات
                            </div>
                            <div class="card-body " style="
    text-align: center;
    font-size: 3rem;
    font-weight: bold;
">
                                <i class="fa fa-minus"></i>

                                {{$allWithdraw}} ل.س
                            </div>
                        </div>


                    </div>
                    <div class="col">
                        <div class="card bg-success" style="color: #fff">
                            <div class="card-header">
                                مجموع الإضافات
                            </div>
                            <div class="card-body" style="
    text-align: center;
    font-size: 3rem;
    font-weight: bold;
">
                                <i class="fa fa-plus"></i>

                                {{$allDeposits}} ل.س
                            </div>
                        </div>


                    </div>
                </div>
                <br>
                <br>

                <h3>العمليات</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">باركود</th>
                        <th scope="col">الاسم</th>
                        <th scope="col"><i class="fa fa-plus"></i>مجموع الإضافات</th>
                        <th scope="col"><i class="fa fa-minus"></i>مجموع الحسومات</th>
                        <th scope="col">قيمة البطاقة الحالية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cards as $card)
                        <tr>
                            <td>{{$card->barcode}}</td>
                            <td>{{$card->name}}</td>
                            <td>{{$card->deposits_sum_amount ?? 0}} ل.س</td>
                            <td>{{$card->withdraw_sum_amount ?? 0}} ل.س</td>
                            <td>{{$card->balance}} ل.س</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>


</x-app-layout>
