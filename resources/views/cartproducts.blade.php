@extends('layouts.index')

@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>

                <tr class="cart_menu">
                    <td class="image">Produs</td>
                    <td class="description"></td>
                    <td class="price">Pret</td>
                    <td class="quantity">Cantitate</td>
                    <td class="total">Total</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems->items as $item)
                <tr>
                    <td class="cart_product">
                        <a href=""><img src="{{ Storage::disk('local')->url('product_images/'.$item['data']['image']) }}" width="100" height="100" alt=""></a>
                    </td>
                    <td class="cart_description">
                        <h4><a href="">{{$item['data']['name']}}</a></h4>
                        <p>{{$item['data']['description']}} - {{$item['data']['type']}}</p>
                        <p>id: {{$item['data']['id']}}</p>
                    </td>
                    <td class="cart_price">
                        <p>{{$item['data']['price']}}</p>
                    </td>
                    <td class="cart_quantity">
                        <div class="cart_quantity_button">
                            <a class="cart_quantity_up" href=""> + </a>
                            <input class="cart_quantity_input" type="text" name="quantity" value="{{$item['quantity']}}" autocomplete="off" size="2">
                            <a class="cart_quantity_down" href=""> - </a>
                        </div>
                    </td>
                    <td class="cart_total">
                        <p class="cart_total_price">{{$item['totalSinglePrice']}}</p>
                    </td>
                    <td class="cart_delete">
                        <a class="cart_quantity_delete" href="{{ route('DeleteItemFromCart', ['id'=>$item['data']['id']]) }}"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">

        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Cantitate <span>{{ $cartItems->totalQuantity }}</span></li>
                        <li>Cost Transport<span>Free</span></li>
                        <li>Total <span>{{ $cartItems->totalPrice }}</span></li>
                    </ul>

                    <a class="btn btn-default check_out" href="">Cumpara</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endsection
