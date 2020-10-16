@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                Mpesa
            </div>
        </div>
        <div class="row">

            <div class="card col-6 ">
                <div class="card-header">
                    C2B
                </div>
                <div class="card-body">
                    <form action="{{ route('c2bcall') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="my-input">Phone</label>
                            <input id="my-input" class="form-control" type="text" name="phone">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="card-footer">
                    @if (session('c2b'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @foreach (session('c2b') as $item)
                            {{ $item }}
                        @endforeach

                    </div>
                @endif
                </div>
            </div>

            <div class="card  col-6 ">
                <div class="card-header">
                    B2C
                </div>
                <div class="card-body">
                    <form action="{{ route('b2vcall') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="my-input">Phone</label>
                            <input id="my-input" class="form-control" type="text" name="phone">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="card-footer">
                        @if (session('b2c'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                @foreach (session('b2c') as $item)
                                    {{ $item }}
                                @endforeach

                            </div>
                        @endif
                    </div>
                </div>


            </div>

            <div class="card col-6 ">
                <div class="card-header">
                    Lipa na Mpesa Online
                </div>
                <div class="card-body">
                    <form action="{{ route('lipanampesa') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="my-input">Phone</label>
                            <input id="my-input" class="form-control" type="text" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="my-input">Amount</label>
                            <input id="my-input" class="form-control" type="text" name="amount">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="card-footer">
                    @if (session('lipanampesa'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            @foreach (session('lipanampesa') as $item)
                                {{ $item }}
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>

            <div class="card col-6 ">
                <div class="card-header">
                    Initiate Mpesa reversal
                    <div>Testing with fake Transaction Id</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('reverse') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="my-input">Transaction id</label>
                            <input id="my-input" disabled class="form-control" type="text" value="LGR019G3J2" name="tras">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="card-footer">


                        @if (session('reversepesa'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            @foreach (session('reversepesa') as $item)
                                {{ $item }}
                            @endforeach

                        </div>
                    @endif


                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
