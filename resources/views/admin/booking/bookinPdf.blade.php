<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&subset=devanagari" rel="stylesheet">
    <title>Booking</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        table {
            border: 1px solid #000;
            width: 100%;
        }

        td {
            border: 1px solid #000;
            padding: 10px;
            width: 33.33%;
        }

        .div1 {
            border: 1px solid #000;
            padding: 10px;
        }

        .myImg {
            text-align: center;
        }

        .tddata {
            border: 1px solid #000;
            padding: 10px;
            width: 25%;
        }
        .sign1 {
            float: left;
        }
        .sign2 {
            float: right;
        }
    </style>
</head>
<body>
    @foreach ($carbooking as $data)
        <div class="div1">
            <div>
                <table>
                    <tr>
                        <td class="myImg">
                            {{-- <img src="{{url('assets/img/logo.jpg')}}" width="200px" > --}}
                            <img src="assets/img/logotrans.png" width="175px">
                        </td>
                        <td style="text-align: center;">
                            <div style="margin: auto; width: 50%; padding: 10px;">
                                <p><strong>Booking Slip</strong></p>
                                <p> {!! DNS1D::getBarcodeHTML($data->booking_no, 'C128', 1, 30) !!} </p></br>
                                <strong>{{ $data->booking_no }}</strong>
                            </div>
                        </td>
                        <td>
                            <p style="text-align: center;"><strong style="font-size: 30px;">Car 4 Sales </strong></p>
                            <p style="text-align: justify">Chandani Cowk, Near Mahindra & Mahindra Showroom, Near Over
                                Bridge, Muzaffarpur, Bihar, 842003</p>
                            <p><strong>Ph. 777 999 5656</strong></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="margin-top: 10px">
                <table>
                    <tr>
                        <td class="tddata">Booking Date</td>
                        <td class="tddata"><strong>{{ date('d-M-Y', strtotime($data->created_at)) }}</strong></td>
                        <td class="tddata">Booking Person</td>
                        <td class="tddata" colspan="4"><strong>{{ $data->booking_person }}</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Customer Name</td>
                        <td class="tddata"><strong>{{ strtoupper($data->name) }}</strong></td>
                        <td class="tddata">Father's Name</td>
                        <td class="tddata"><strong>{{ strtoupper($data->father) }}</strong></td>
                        <td class="tddata">Mobile No.</td>
                        <td class="tddata"><strong>{{ $data->mobile }}</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Aadhar No.</td>
                        <td class="tddata"><strong>{{ $data->aadhar }}</strong></td>
                        <td class="tddata">Pan No.</td>
                        <td class="tddata"><strong>{{ strtoupper($data->pan) }}</strong></td>
                        <td class="tddata">City</td>
                        <td class="tddata"><strong>{{ strtoupper($data->city) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Address</td>
                        <td class="tddata" colspan="5"><strong>{{ $data->address }}</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Registration No.</td>
                        <td class="tddata"><strong>{{ strtoupper($data->regnumber) }}</strong></td>
                        <td class="tddata">Model Name</td>
                        <td class="tddata"><strong>{{ strtoupper($data->carmodel) }}</strong></td>
                        <td class="tddata">Model Year</td>
                        <td class="tddata"><strong>{{ $data->model_year }}</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Sell Amount</td>
                        <td class="tddata"><strong>{{ $data->total_amount }}/-</strong></td>
                        <td class="tddata">Advance</td>
                        <td class="tddata"><strong>{{ $data->adv_amount }}/-</strong></td>
                        <td class="tddata">Estimated Finance Amount</td>
                        <td class="tddata"><strong>{{ $data->finance_amount }}/-</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Estimated Down Payment</td>
                        <td class="tddata"><strong>{{ $data->due_amount }}/-</strong></td>
                    </tr>
                    <tr>
                        <td class="tddata">Remarks</td>
                        <td class="tddata" colspan="5"><strong>{{ strtoupper($data->remarks) }}</strong></td>
                    </tr>
                </table>
            </div>
            <div>
                <h3>Terms & Conditions</h3>
                <hr>
            </div>
            <div>
                <ol type="1">
                    <li>Booking Amount is Rs.21000/-</li>
                    <li>The file charge for the loan should be paid separately.</li>
                    <li>After compleating the loan process you will be able to recive your Car/Jeep</li>
                    <li>Only Available Insurance of car Will be Provided</li>
                    <li>If non Avaibility of Insurance, then new insurance will be provided by Car4Sales for Next 1 Year
                    </li>
                    <li>Booking Canclelation charge is 21000/-</li>
                    <li>After Loan Approval Cancellation charge will be 7% of total Loan Amount.</li>
                    <li>Refunds will be provided in accordance with our refund policy, which may vary depending on the
                        circumstances.</li>
                    <li>Any modifications to these terms and conditions must be agreed upon in writing by both parties.
                    </li>
                    <li>These terms and conditions shall be governed by and construed in accordance with the laws of
                        Muzaffarpur(Bihar) jurisdiction</li>
                    <li>Any disputes arising from these terms and conditions will be subject to the exclusive
                        jurisdiction
                        of the courts in Muzaffarpur(Bihar) jurisdiction </li>
                    <li>By availing of our services, you acknowledge that you have read, understood, and agree to
                        these terms and conditions.</li>
                </ol>
            </div>
            <div>
                <h3>Financer Paper List</h3>
                <hr>
            </div>
            <div>
                <table>
                    <tr>
                        <td>Aadhar Card (Apllicant & Co-Applicant)</td>
                        <td>Pan Card (Apllicant & Co-Applicant)</td>
                        <td>Bank Statement (6 Month)</td>
                        <td>Propoerty Tax Reciept</td>
                        <td>Income tax Reciept</td>
                        <td>4 Month Salary Slip</td>
                        <td>Cheque 6 Qty</td>
                    </tr>
                </table>
            </div>
            <div style="margin: 100px 50px 50px 50px;">
                <div class="sign1">
                    <p>Buyer Sign</p>
                </div>
                <div class="sign2">
                    <p>Sign (Car4Sales)</p>
                </div>
            </div>
        </div>
    @endforeach

</body>

</html>
