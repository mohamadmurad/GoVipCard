<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 float-right">
            {{ __('البطاقة رقم ' .$card->barcode ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">



                <div class="float-right" style="margin-bottom:50px;">
                    <h2>الرصيد الحالي للبطاقة : <span class="font-semibold text-gray-800">{{ $card->balance }}</span>
                    </h2>

                </div>

                <div style="clear: both;"></div>
                <form method="post" action="{{route('deposit')}}" id="withdrawForm">
                    @csrf
                    <div class="form-group">
                        <label >ادخل القيمة التي تريد اضافتها للبطاقة</label>
                        <input type="number" class="form-control" name="amount" placeholder="القيمة التي تريد اضافتها للبطاقة" required min="1"
                               autofocus>
                        <input type="hidden" class="" name="barcode" value="{{$card->barcode}}">
                        <small  class="form-text text-muted">يجب ان لا تكون القيمة سالبة او صفر</small>
                        <ul class="errors">
                            @foreach ($errors->get('amount') as $message)
                                <i>{{ $message }}</i>
                            @endforeach
                        </ul>
                    </div>
                    <div style="clear: both;"></div>


                    <button type="submit" class="btn btn-primary">إضافة</button>

                </form>

                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>المستخدم</th>
                        <th>القيمة</th>

                        <th>التاريخ</th>

                    </tr>
                    <?php $i = 0?>
                    @foreach ($card->deposits as $deposit)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $deposit->user->name }}</td>
                            <td>{{ $deposit->amount }}</td>

                            <td>{{ $deposit->date }}</td>

                        </tr>
                    @endforeach
                </table>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
