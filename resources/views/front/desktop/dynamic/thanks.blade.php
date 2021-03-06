@extends('../front.desktop.app')
@section('content')
@include('front.desktop.partials.header')
<main class="thanksContent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                {{-- <h3>{{ trans('vars.PagesThankYou.thankMessage') }} {{ @$order->details->contact_name }}!</h3> --}}
            </div>
            <div class="col-lg-8">
                <img src="/fronts/img/backgrounds/thanksbox.png" alt="">
            </div>

            @php
                $ammount = 0;
                $shippingPrice = @$currency->rate * $order->shipping_price;
            @endphp

            <div class="col-lg-10">
                <h5>{{ trans('vars.PagesThankYou.ourOrder') }}</h5>
                <div class="row productsList">
                    <div class="col-12">
                        @if ($order->orderProducts()->count() > 0)
                        @foreach ($order->orderProducts as $key => $product)
                        @if (!is_null($product->product))
                        <div class="row cartItem fbq-content" data-id="{{ $product->product->code }}" data-qty="{{ $product->qty }}" data-type="{{ $product->product->homewear == 1 ? 'homewear' : 'bijoux' }}"  data-price="{{ $product->product->mainPrice->price }}">
                            <a class="col-auto" href="{{ url('/'.$lang->lang.'/'.$site.'/catalog/'.$product->product->category->alias.'/'.$product->product->alias) }}">
                            @if ($product->product->mainImage)
                                <img src="/images/products/og/{{ $product->product->mainImage->src }}" alt="" />
                            @else
                                <img src="" alt="" />
                            @endif
                            </a>
                            <div class="description col-md">
                                <a href="{{ url('/'.$lang->lang.'/'.$site.'/catalog/'.$product->product->category->alias.'/'.$product->product->alias) }}">
                                    {{ $product->product->translation->name }}
                                </a>
                                <div class="params">
                                    <span>{{ trans('vars.DetailsProductSet.qty') }}: {{ $product->qty }}</span>
                                </div>
                            </div>
                            <div class="price col-auto">
                                @if ($product->product->personalPrice)
                                    @if ($product->set_id)
                                        <span>{{ $product->product->personalPrice->set_price }} {{ $currency->abbr }}</span>
                                    @else
                                        <span>{{ $product->product->personalPrice->price }} {{ $currency->abbr }}</span>
                                    @endif
                                @endif
                                @php
                                    $ammount +=  $product->set_id ? $product->product->personalPrice->set_price * $product->qty : $product->product->personalPrice->price * $product->qty;
                                @endphp
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif

                        @if ($order->orderSubproducts()->count() > 0)
                        @foreach ($order->orderSubproducts as $key => $subproduct)
                        @if (!is_null($subproduct->product))
                        <div class="row cartItem fbq-content" data-id="{{ $subproduct->product->code }}" data-qty="{{ $subproduct->qty }}" data-type="{{ $subproduct->product->homewear == 1 ? 'homewear' : 'bijoux' }}" data-price="{{ $subproduct->product->mainPrice->price }}">
                            <a href="{{ url('/'.$lang->lang.'/'.$site.'/catalog/'.$subproduct->product->category->alias.'/'.$subproduct->product->alias) }}">
                            @if ($subproduct->product->mainImage)
                                <img src="/images/products/og/{{ $subproduct->product->mainImage->src }}" alt="" />
                            @else
                                <img src="" alt="" />
                            @endif
                            </a>
                            <div class="description col-md">
                                <a href="{{ url('/'.$lang->lang.'/'.$site.'/catalog/'.$subproduct->product->category->alias.'/'.$subproduct->product->alias) }}">
                                    {{ $subproduct->product->translation->name }}
                                </a>
                                <div class="params">
                                    <span>{{ trans('vars.DetailsProductSet.qty') }}: {{ $subproduct->qty }}</span>
                                    <span>{{ trans('vars.DetailsProductSet.size') }}: {{ $subproduct->subproduct->parameterValue->translation->name }}</span>
                                </div>
                                <div class="methods">
                                    <div class="methods"></div>
                                </div>
                            </div>
                            <div class="price col-auto">
                                @if ($subproduct->product->personalPrice)
                                    <span>{{ $subproduct->product->personalPrice->price }} {{ $currency->abbr }}</span>
                                @endif
                                @php
                                    $ammount +=  $subproduct->product->personalPrice->price * $subproduct->qty;
                                @endphp
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @php
                $discount = $ammount - ($ammount - ($ammount * $order->discount / 100))
            @endphp

            <div class="col-lg-10 text-center">
                <p>{{ trans('vars.Orders.orderId') }}: {{ $order->id }}</p>
            </div>
            <h5>{{ trans('vars.Orders.invoiceValue') }} - {{ $ammount - $discount + $shippingPrice }} {{ $order->currency->abbr }}</h5>
            <div class="col-lg-10">
                @if ($order->discount > 0)
                    <h5 class="text-center"><small>Discount - {{ $discount }} {{ $order->currency->abbr }}</small></h5>
                @endif
                <div id="_purchase" data="{{ $ammount + $shippingPrice }}"></div>
            </div>

            <div class="col-lg-10 thanks">
                {{-- <h5>{{ trans('vars.PagesThankYou.row1') }}:</h5>
                <p>
                    {{ trans('vars.PagesThankYou.thanksTrackOrderByEmail') }}
                </p> --}}

                @if ($promocode)
                    <h5>{{ trans('vars.PagesThankYou.giftTitle') }}</h5>
                    <p>
                        {{ trans('vars.PagesThankYou.EnterPromocode') }}
                        {{ $promocode->name }}
                        {{ trans('vars.PagesThankYou.whenYouMake') }}
                        {{ $promocode->treshold }}
                        {{ trans('vars.PagesThankYou.euroOrMore') }}
                        {{ date("j F Y", strtotime($promocode->valid_to)) }}
                        {{ trans('vars.PagesThankYou.andEnjoy') }}
                        {{ $promocode->discount }}
                        {{ trans('vars.PagesThankYou.off') }}
                    </p>
                @endif
                <p class="continue">{{ trans('vars.PagesThankYou.row3') }}</p>
                <div class="buttGroups">
                    <a class="butt" href="{{ '/' . $lang->lang. '/homewear' }}">{{ trans('vars.General.HomewearStore') }}</a>
                    <a class="butt" href="{{ '/' . $lang->lang. '/bijoux' }}">{{ trans('vars.General.BijouxBoutique') }}</a>
                </div>
            </div>
        </div>
    </div>
</main>

@include('front.desktop.partials.footer')
@stop

@section('purchase-event')
    @if (Request::route()->getName() == 'thanks')
    <script>
        if ($("#_purchase").length > 0){
            let ammount = '{{ $ammount - ($ammount * $order->discount / 100) }}';
            let currency = document.documentElement.getAttribute("main-currency");
            let contents = [];
            let contentsHomewear = [];
            let contentsBijoux = [];
            let amountHomewear = 0;
            let amountBijoux = 0;

            for (var i = 0; i < $('.fbq-content').length; i++) {
                contents.push({
                    'id' : $('.fbq-content').eq(i).attr('data-id'),
                    'quantity': $('.fbq-content').eq(i).attr('data-qty')
                });
                amountHomewear += $('.fbq-content').eq(i).attr('data-price');
            }

            amountHomewear = parseFloat(amountHomewear);
            amountBijoux = parseFloat(amountBijoux);
            ammount = parseFloat(ammount);

            fbq("track", "Purchase", {
                contents: contents,
                content_type: 'product',
                value: amountHomewear.toFixed(2),
                currency: 'EUR'
            });

            dataLayer.push({
                'event': 'eec.purchase',
                'ecommerce' : {
                    'currencyCode': currency,
                    'purchase' :{
                        'actionField': {
                            'id': "{{ $order->order_hash }}",
                            'affiliation': 'Online Store',
                            'revenue': amountHomewear.toFixed(2),
                            'shipping': '{{ $shippingPrice }}',
                            'coupon': '{{ @$order->details->promocode }}'
                        },
                        'products' : [
                            @foreach ($order->orderSubproducts as $key => $subproduct)
                            {
                                'id'    : '{{ $subproduct->subproduct->product->code }}',
                                'name'  : '{{ $subproduct->subproduct->product->translation->name }}',
                                'price' : '{{ $subproduct->subproduct->product->mainPrice->price }}',
                                'brand' : 'Soledy',
                                'category': '{{ $subproduct->subproduct->product->category->translation->name }}',
                                'quantity': '{{ $subproduct->qty }}',
                                'coupon': '{{ @$order->details->promocode }}'
                            },
                            @endforeach
                            @foreach ($order->orderProducts as $key => $product)
                            {
                                'id'    : '{{ $product->product->code }}',
                                'name'  : '{{ $product->product->translation->name }}',
                                'price' : '{{ $product->product->mainPrice->price }}',
                                'brand' : 'Soledy',
                                'category': '{{ $product->product->category->translation->name }}',
                                'quantity': '{{ $product->qty }}',
                                'coupon': '{{ @$order->details->promocode }}'
                            },
                            @endforeach
                        ]
                    },
                },
            });

        window.dataLayer.push({
            event: 'purchase',
            ecommerce: {
                currency: 'EUR',
                value: amountHomewear.toFixed(2),
                shipping: "{{ $shippingPrice }}",
                transaction_id: "{{ $order->order_hash }}",
                coupon: "{{ @$order->details->promocode }}",
                items:[
                    @foreach ($order->orderSubproducts as $key => $subproduct)
                    {
                        item_name: '{{ $subproduct->subproduct->product->translation->name }}',
                        item_id: '{{ $subproduct->subproduct->product->code }}',
                        price: '{{ $subproduct->subproduct->product->mainPrice->price }}',
                        item_brand: 'Soledy',
                        item_category: '{{ $subproduct->subproduct->product->category->translation->name }}',
                        item_variant: '---',
                        quantity: '{{ $subproduct->qty }}',
                    },
                    @endforeach
                    @foreach ($order->orderProducts as $key => $product)
                    {
                        item_name: '{{ $product->product->translation->name }}',
                        item_id: '{{ $product->product->code }}',
                        price: '{{ $product->product->mainPrice->price }}',
                        item_brand: 'Soledy',
                        item_category: '{{ $product->product->category->translation->name }}',
                        item_variant: '---',
                        quantity: '{{ $product->qty }}',
                    },
                    @endforeach
                    ]
                },
            });
        }
    </script>
    @endif
@stop
