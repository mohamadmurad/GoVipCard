<x-app-layout>
    <x-slot name="header">



        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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


                <div class="float-left" style="margin-bottom:50px;">
                    <h2>اسم صاحب البطاقة : <span class="font-semibold text-gray-800">{{ $card->name }}</span>
                    </h2>

                </div>
                <div style="clear: both;"></div>
                <!-- Tabs navs -->
                <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                    @if($card->balance > 0)
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link active"
                                id="ex3-tab-1"
                                data-toggle="tab"
                                href="#ex3-tabs-1"
                                role="tab"
                                aria-controls="ex3-tabs-1"
                                aria-selected="true"
                            >حسم
                                <i class="fa fa-minus"></i>
                            </a
                            >
                        </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <a
                            class="nav-link"
                            id="ex3-tab-2"
                            data-toggle="tab"
                            href="#ex3-tabs-2"
                            role="tab"
                            aria-controls="ex3-tabs-2"
                            aria-selected="false"
                        >إضافة رصيد
                        <i class="fa fa-plus"></i>
                        </a
                        >
                    </li>
                </ul>
                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="ex2-content">
                    <div
                        class="tab-pane fade show active"
                        id="ex3-tabs-1"
                        role="tabpanel"
                        aria-labelledby="ex3-tab-1"
                    >
                        @if($card->balance > 0)
                            <form method="post" action="{{route('withdraw')}}" id="withdrawForm">
                                @csrf
                                <div class="form-group">
                                    <label>ادخل قيمة الخصم من البطاقة </label>
                                    <input type="number" class="form-control" name="amount"
                                           placeholder="الرجاء كتابة قيمة الخصم" required min="0"
                                           max="{{$card->balance}}" autofocus>
                                    <input type="hidden" class="" name="barcode" value="{{$card->barcode}}">
                                    <small class="form-text text-muted">يجب ان لا تكون القيمة اكبر من رصيد
                                        البطاقة</small>
                                    <ul class="errors">
                                        @foreach ($errors->get('amount') as $message)
                                            <i>{{ $message }}</i>
                                        @endforeach
                                    </ul>
                                </div>
                                <div style="clear: both;"></div>

                                <div class="form-group">
                                    <label>رقم الفاتورة : </label>
                                    <input type="text" class="form-control" name="orderNo"
                                           placeholder="الرجاء كتابة رقم الفاتورة " required
                                    >
                                    <small class="form-text text-muted">قم بمسح رقم الفاتورة او كتابتها يدوياً</small>
                                    <ul class="errors">
                                        @foreach ($errors->get('orderNo') as $message)
                                            <i>{{ $message }}</i>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="submit" class="btn btn-primary">خصم</button>

                            </form>
                        @endif
                    </div>
                    <div
                        class="tab-pane fade"
                        id="ex3-tabs-2"
                        role="tabpanel"
                        aria-labelledby="ex3-tab-2"
                    >
                        <div style="clear: both;"></div>
                        <form method="post" action="{{route('deposit')}}" id="depositForm">
                            @csrf
                            <div class="form-group">
                                <label>ادخل قيمة الفاتورة</label>
                                <input type="number" class="form-control" name="amount" id="orderAmount"
                                       placeholder="قيمة الفاتورة" required min="1"
                                       autofocus>
                                <input type="hidden" class="" name="barcode" value="{{$card->barcode}}">
                                <small class="form-text text-muted">يجب ان لا تكون القيمة سالبة او صفر</small>
                                <ul class="errors">
                                    @foreach ($errors->get('amount') as $message)
                                        <i>{{ $message }}</i>
                                    @endforeach
                                </ul>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>رقم الفاتورة : </label>
                                <input type="text" class="form-control" name="orderNo"
                                       placeholder="الرجاء كتابة رقم الفاتورة " required
                                >
                                <small class="form-text text-muted">قم بمسح رقم الفاتورة او كتابتها يدوياً</small>
                                <ul class="errors">
                                    @foreach ($errors->get('orderNo') as $message)
                                        <i>{{ $message }}</i>
                                    @endforeach
                                </ul>
                            </div>
                            <div style="clear: both;"></div>

                            <div class="float-right">
                                <p> القيمة التي ستضاف للبطاقة <span id="cardBalance" style="color: #ff3e3e;"></span></p>

                            </div>


                            <button type="submit" class="btn btn-danger">إضافة</button>

                        </form>
                    </div>

                </div>
                <!-- Tabs content -->


                <hr width="100%" class="mt-4 mb-4">

                <div class="table-responsive col-xs-12 col-md-6 col-lg-6 float-right">
                    <p class="float-right">عمليات الاضافة</p>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>المستخدم</th>
                            <th>القيمة</th>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            @if (Auth::user()->isAdmin == 1)
                            <th>#</th>
@endif
                        </tr>
                        <?php $i = 0?>
                        @foreach ($card->deposits as $deposit)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $deposit->user->name }}</td>
                                <td>{{ $deposit->amount }}</td>
                                <td>{{ $deposit->orderNo }}</td>
                                <td>{{ $deposit->date }}</td>
                                @if (Auth::user()->isAdmin == 1)
                                <td>
                                    <form action="{{route('DeleteDeposit',['id'=>$deposit->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete_btn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif

                            </tr>
                        @endforeach
                    </table>
                </div>



                <div class="table-responsive col-xs-12 col-md-6 col-lg-6 float-left">
                    <p class="float-right">عمليات الخصم</p>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>المستخدم</th>
                            <th>القيمة</th>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>

                        </tr>
                        <?php $i = 0?>
                        @foreach ($card->withdraw as $withdraw)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $withdraw->user->name }}</td>
                                <td>{{ $withdraw->amount }}</td>
                                <td>{{ $withdraw->orderNo }}</td>
                                <td>{{ $withdraw->date }}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
