<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>
    body,html{margin:0 auto!important;padding:0!important;height:100%!important;width:100%!important;background:#f1f1f1}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}div[style*="margin: 16px 0"]{margin:0!important}table,td{mso-table-lspace:0!important;mso-table-rspace:0!important;border:1px solid #eee;padding:10px}table{border-spacing:0!important;border-collapse:collapse!important;table-layout:fixed!important;margin:0 auto!important}img{-ms-interpolation-mode:bicubic}a{text-decoration:none}.aBn,.unstyle-auto-detected-links *,[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}.a6S{display:none!important;opacity:.01!important}.im{color:inherit!important}img.g-img+div{display:none!important}@media only screen and (min-device-width:320px) and (max-device-width:374px){u~div .email-container{min-width:320px!important}}@media only screen and (min-device-width:375px) and (max-device-width:413px){u~div .email-container{min-width:375px!important}}@media only screen and (min-device-width:414px){u~div .email-container{min-width:414px!important}}div.email-container{width:100%;overflow:hidden;display:block;background-image:url(https://annepopova.com/fronts/img/icons/fonTechniquePages.png);background-repeat:repeat;padding-left:15px;padding-right:15px}.addit,p{text-align:center;font-family:'Source Sans Pro';font-size:20px;color:#2f2f2f;letter-spacing:-.05px;text-align:left;line-height:25px;margin:0}.userName{font-family:'Source Sans Pro';font-size:50px;color:#000;letter-spacing:-.08px;text-align:left;margin-bottom:30px}.logo{display:block;background-image:url(https://annepopova.com/fronts/img/icons/logoAfter.png);background-size:110px 110px;background-position:50px center;background-repeat:no-repeat;height:130px;margin-top:30px}.gift{font-family:'Source Sans Pro';font-size:30px;color:#2f2f2f;letter-spacing:-.06px;text-align:left;margin-top:20px;margin-bottom:5px}.addit{margin-top:30px}a.butt{display:block;height:40px;line-height:40px;font-size:20px;text-transform:uppercase;background-color:#4b483d;width:245px;text-align:center;color:#fff;margin-left:0;margin-top:10px;font-family:'Source Sans Pro'}.buttGroups{display:flex;width:650px;margin-left:0}.buttGroups .butt{margin-right:20px}.miss{margin-top:20px}.ignore{margin-top:30px;margin-bottom:60px}.logo2{background-image:url(https://annepopova.com/fronts/img/icons/logo2.png);background-repeat:no-repeat;background-size:100%;height:40px;width:150px;margin-left:0}ul{display:block;padding-left:17px;list-style:none}ul a,ul li{font-family:'Source Sans Pro';font-size:18px;color:#2f2f2f;letter-spacing:-.05px;text-align:left;line-height:25px;margin:0;list-style:none}td,th{text-align:center}td p,td small{text-align:center}table{margin:50px 0}
    </style>
</head>

<body>
    <div class="email-container">
        <div class="userName">Hello, Admin </div>
        <p>Order with <b>{{ $problem }}</b></p> <br>
        <p>
            New order details:
        </p> <br>
        <ul class="info">
            <li>Date: {{ date('Y.m.d h:i:s') }}</li>
            <li>Order Hash: {{ $order->order_hash }}</li>
            <li>Order ID: {{ $order->order_id }}</li>
            <li>Order Reference: {{ $order->order_reference }}</li>
            <li>Name: {{ $order->details->contact_name }}</li>
            <li>Email: {{ $order->details->email }}</li>
            <li>Phone: +{{ $order->details->code }} {{ $order->details->phone }}</li>
            <li>Amount: {{ $order->amount }} EUR</li>
        </ul> <br>

        <p>
            Order products:
        </p> <br> <br>

        <div class="row" width="100%">
            <table width="100%" class="table table-hover table-striped">
                <thead>
                    <th class="text-center">type</th>
                    <th>code</th>
                    <th>name</th>
                    <th>details</th>
                    <th>qty</th>
                    <th>discount</th>
                    <th>old price</th>
                    <th>price</th>
                </thead>
                <tbody>
                    @if ($orderProducts->count())
                        @foreach ($orderProducts as $key => $product)
                            @if (!is_null($product))
                            <tr>
                                <td class="text-center">
                                    <span class="label label-primary">product</span>
                                </td>
                                <td>
                                    <p>{{ $product->code }}</p>
                                </td>
                                <td>
                                    {{ $product->product->translation->name }}
                                </td>
                                <td>---</td>
                                <td>{{ $product->qty }}</td>
                                <td>{{ $product->discount ? $product->discount : '---' }}</td>
                                <td>{{ $product->old_price }}</td>
                                <td>{{ $product->price }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>Deleted product</td>
                            </tr>
                        @endif

                        @endforeach
                    @endif

                    @if ($orderSubproducts->count())
                        @foreach ($orderSubproducts as $key => $subproduct)
                            @if (!is_null($subproduct->subproduct))

                            <tr>
                                <td class="text-center">
                                    <span class="label label-success">subproduct</span>
                                </td>
                                <td>
                                    <p><small>{{ $subproduct->code }}</small> </p>
                                </td>
                                <td>
                                    {{ $subproduct->subproduct->product->translation->name }}
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $subproduct->subproduct->parameterValue->translation->name }}
                                    </span>
                                </td>
                                <td>{{ $subproduct->qty }}</td>
                                <td>{{ $subproduct->subproduct->product->discount ? $subproduct->subproduct->product->discount.'%' : '---'  }}</td>
                                <td>{{ $subproduct->subproduct->product->mainPrice->old_price }}</td>
                                <td>{{ $subproduct->subproduct->product->mainPrice->price }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>Deleted Subproduct</td>
                            </tr>
                        @endif

                        @endforeach
                    @endif
                </tbody>
        </div>

        <p class="ignore">
             In case You didn't do actions mentioned above or this mail doesn't refer to You, please ignore the message.
        </p>
        <p style="text-align: left">Trully Yours,</p>
        <ul class="info">
            <li>{{ trans('vars.General.brandName') }}</li>
            <li>{{ trans('vars.FormFields.fieldEmail') }}: {{ trans('vars.Contacts.queriesPaymentShippingReturnsEmail') }}</li>
            <li>{{ trans('vars.FormFields.fieldphone') }}: {{ trans('vars.Contacts.queriesPaymentShippingReturnsPhone') }}</li>
            <li>{{ trans('vars.Contacts.contactsLabelAddressShowroom') }}: {{ trans('vars.Contacts.addressSiteShopMDAdress') }}</li>
        </ul>
    </div>
</body>
</html>
