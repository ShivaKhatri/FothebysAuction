@extends('backend.sellerLayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Buyers') }}</div>

                    <div class="card-body">
                        <p class="card-text">By signing the agreement, you are confirming the following to be true:-

                            1)	I am the sole owner of the piece described above.
                            2)	To the best of my knowledge the description of the piece is accurate and true.
                            3)	I believe the piece to be authentic.
                            4)	I authorise Fotherby’s Ltd to act on my behalf to sell the piece for a price not below my agreed reserve price.
                            5)	I agree to pay Fotherby’s Ltd 10% of the final sale price as payment for the services provided.
                            6)	Should I wish to withdraw the piece from sale, it must be done in writing, a maximum of two weeks after the auction date has been set, otherwise I understand I will be liable to pay Fotherby’s Ltd a fee of 5% of the least estimated price.
                        </p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

@endsection



