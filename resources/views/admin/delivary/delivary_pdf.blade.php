<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&subset=devanagari" rel="stylesheet">
    <title>Car4Sales Booking Slip</title>
    <style>
        * {
            font-family: 'Noto Sans', sans-serif;
            font-size: 11px;
        }

        body {
            margin: 0;
            padding: 2px;
            background: #fff;
            color: #333;
        }

        .container {
            margin: 0 auto;
            padding: 3px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header img {
            width: 150px;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 12px;
            color: #f20000;
            font-weight: 900;
        }

        .header p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .section-title {
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 5px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signatures div {
            text-align: center;
        }

        .terms,
        .financier-list {
            margin-bottom: 5px;
        }

        .terms ol {
            padding-left: 20px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            margin-top: 70px;
            font-size: 10px;
            color: #777;
        }

        /* Gatepass */

        .gatepassbody {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container1 {

            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .header1 {
            text-align: right;
        }

        .header1 img {
            width: 150px;
            float: left;
        }

        .header1 h1 {
            font-size: 18px;
            color: red;
            text-align: left;
            margin: 0;
            padding: 0;
        }

        .header1 .info {
            font-size: 12px;
            margin-top: 0;
            float: right;
        }

        .header1 .info p {
            margin: 2px 0;
        }

        .clear1 {
            clear: both;
        }

        .title1 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: red;
            margin: 20px 0;
        }

        .details1 {
            font-size: 14px;
        }

        .details1 input[type="text"],
        .details1 input[type="number"] {

            border: none;
            border-bottom: 1px solid #000;
            outline: none;
        }

        .checkbox-group {
            margin-top: 20px;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 20px;
        }

        .sign-section {
            margin-top: 30px;
        }

        .sign-section .column {
            float: left;
            width: 33.3%;
            text-align: center;
        }

        .sign-section .column input[type="text"] {
            width: 150px;
            border: none;
            border-bottom: 1px solid #000;
        }

        .remarks1 {
            margin-top: 40px;
        }

        .remarks1 textarea {
            width: 100%;
            height: 80px;
            border: 1px solid #000;
        }

        .footer1 {
            margin-top: 20px;
        }

        .footer1 p {
            font-size: 12px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    <div class="container">
        <div style="margin-top: 5px; margin-bottom: 10px;">
            <div style="float: left">
                <p>GSTIN : 10AVYPK5002H3ZP</p>
            </div>

            <div style="float: right">
                <p>website : www.car4sales.in</p>
            </div>
        </div>

        <div class="header">
            <img src="assets/img/logotrans.png" alt="Car4Sales Logo">
            <p><strong style="font-size: 16px;">Car for Sales Sale Buy & Services</strong></p>
            <p><strong style="font-size: 10px;">Chandani Chowk, Near Mahindra & Mahindra Showroom, Near Over Bridge,
                    Muzaffarpur, Bihar, 842003</strong></p>
            <p><strong style="font-size: 10px;">Ph : 777 999 5656</strong></p>
            <p><strong><u>Delivary Slip/Aggrement</u></strong> </p>
        </div>

        <hr style="margin-top: 10px">

        <div style="margin-top: 10px">
            <table>
                <tr>
                    <th style="text-align: center; font-size: 10px">Seller Information</th>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th>Date</th>
                    <td>{{ date('d/M/Y', strtotime($getRecords[0]['created_at'] ))}}</td>
                    <th>Seller Name</th>
                    <td>Amit Kumar</td>
                    <th>Seller Father's Name</th>
                    <td>Ramekbal Prasad</td>
                </tr>

                <tr>
                    <th>Address</th>
                    <td colspan="5">Mahamaya Mandir, Damodarpur, Post:Damodarpur, Ps:Kanti, Muzaffarpur, Bihar. 843113</td>
                </tr>
                <tr>
                    <th>Booking Number</th>
                    <td>{{ $getRecords[0]['booking_id'] }}</td>
                    <th>Booking Person</th>
                    <td>{{ $getRecords[0]['booking_person'] }}</td>
                    <th>Registration</th>
                    <td>{{ $getRecords[0]['reg_number'] }}</td>
                </tr>
                <tr>
                    <th>Car Model</th>
                    <td>{{ $getRecords[0]['model_name'] }}</td>
                    <th>Model Year</th>
                    <td>{{ $getRecords[0]['model_year'] }}</td>
                    <th>Colour</th>
                    <td>{{ $getRecords[0]['car_color'] }}</td>

                </tr>
                <tr>
                    <th>Owner Sl No.</th>
                    <td>{{ $getRecords[0]['owner_sl_no'] }}</td>
                    <th>Engine No </th>
                    <td>{{ $getRecords[0]['eng_number'] }}</td>
                    <th>Chasis No.</th>
                    <td>{{ $getRecords[0]['chassis_number'] }}</td>
                </tr>
                <tr>
                    <th>Sell Amount</th>
                    <td>{{ $getRecords[0]['sell_amount'] }}/-</td>
                    <th>Booking Amount</th>
                    <td>{{ $getRecords[0]['booking_amount'] }}/-</td>
                    <th>Finance Amount</th>
                    <td>{{ $getRecords[0]['finance_amount'] }}/-</td>
                </tr>
                <tr>
                    <th>Down Payment</th>
                    <td>{{ $getRecords[0]['dp'] }}/-</td>
                    <th>Remarks</th>
                    <td  colspan="3">{{ $getRecords[0]['remarks'] }}</td>
                </tr>
                <tr>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th style="text-align: center; font-size: 10px">Buyer Information</th>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th>Buyer Name</th>
                    <td>{{ $getRecords[0]['name'] }}</td>
                    <th>Father's Name</th>
                    <td>{{ $getRecords[0]['father_name'] }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td colspan="3">{{ $getRecords[0]['address'] }}</td>
                </tr>
                <tr>
                    <th>Aadhar No.</th>
                    <td>{{ $getRecords[0]['aadhar'] }}</td>
                    <th>Pan Card</th>
                    <td>{{ $getRecords[0]['pan_card'] }}</td>
                </tr>
            </table>
        </div>

        <!-- Terms and Conditions -->
        <div class="terms">
            <h3 class="section-title">Terms & Conditions:</h3>
            <ol>
                <li>The responsibility of the RC (Registration Certificate) lies with the DTO office, not the showroom.
                </li>
                <li>Once the RC (Registration Certificate) is updated online, ensure that the insurance is transferred
                    to your name. Otherwise, the showroom will not be responsible if a claim is denied.</li>
                <li>When purchasing the vehicle, make sure to check the toolbox and stepney, as the showroom will not be
                    responsible for them later.</li>
                <li>After taking delivery of the vehicle, CarforSales will not be responsible for any kind of damages
                    related to the vehicle</li>
                <li>In case of accidental damage, we assure that the apron, pillars, and chassis have not been repaired.
                </li>
                <li>Any debt or legal claim arising after delivery will be the responsibility of the buyer.</li>
                <li>There is no mention of vehicle return in this agreement. However, if any documents related to the
                    vehicle are found to be incorrect in any way, the vehicle must be returned to Car4Sales.</li>
                <li>The buyer is purchasing the car after being satisfied with the documents and after test-driving the
                    vehicle.</li>
                <li>The jurisdiction for any disputes or legal matters related to this agreement falls under
                    Muzaffarpur.</li>
                <li>By availing of our services, you acknowledge that you have read, understood, and agree to these
                    terms and conditions.</li>
            </ol>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div style="float: left">
                <p>____________________</p>
                <p>Buyer Sign</p>
            </div>
            <div style="float: right">
                <p>____________________</p>
                <p>Authorized Sign (Car4Sales)</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing Car4Sales. For any inquiries, contact us at +91 777 999 5656.</p>
        </div>


    </div>
    <div class="page-break" >
        {{-- <div class="gatepassbody">
            <div class="container1">
                <div class="header1">
                    <img src="assets/img/logotrans.png" alt="Motor Kenya Lounge">
                    <div class="info">
                        <p>Chandani Chowk, Near Mahindra & Mahindra Showroom, </p>
                        <p>Near Over Bridge, Muzaffarpur, Bihar, 842003</p>
                        <p>Tel: 777 999 5656</p>
                    </div>
                </div>
                <div class="clear1"></div>
        
                <div class="title1">GATE PASS / DELIVERY SLIP</div>
        
                <div>

                </div>
                <div class="details1">
                    <p>Date: <input type="text" name="date"></p>
                    <p>Client: <input type="text" name="client"></p>
                    <p>Make: <input type="text" name="make"> Type: <input type="text" name="type"></p>
                    <p>Reg. No: <input type="text" name="regNo"> Colour: <input type="text" name="color"> Mileage: <input type="number" name="mileage"></p>
        
                    <div class="checkbox-group">
                        <p>Jack Handle <input type="checkbox"> Jack <input type="checkbox"> SD Card <input type="checkbox"> Radio <input type="checkbox"> CD <input type="checkbox"></p>
                        <p>Mats <input type="checkbox"> H/Rest <input type="checkbox"> C/Lighter <input type="checkbox"> Spare Wheel <input type="checkbox"> Wheel Spanner <input type="checkbox"></p>
                    </div>
                </div>
        
                <div class="sign-section">
                    <div class="column">
                        <p>Dispatched by: <input type="text" name="dispatchedBy"></p>
                    </div>
                    <div class="column">
                        <p>Authorized by: <input type="text" name="authorizedBy"></p>
                    </div>
                    <div class="column">
                        <p>Received by: <input type="text" name="receivedBy"></p>
                    </div>
                    <div class="clear"></div>
                </div>
        
                <div class="remarks1">
                    <p>Remarks:</p>
                    <textarea name="remarks"></textarea>
                </div>
        
                <div class="footer1">
                    <p>ID: <input type="text" name="id"></p>
                </div>
            </div>
        </div> --}}
        <div>
            <div style="margin-top: 550px; padding-left: 10px">
                <p>
                    I, <strong>Amit Kumar,</strong> S/o Shri Ramekbal Prasad, residing at Mahamaya Mandir, Damodarpur, Post:Damodarpur, Ps:Kanti, Muzaffarpur, Bihar. 843113. hereby declare that I am selling my vehicle with the following details:
                </p>
                <p>
                    <strong>Vehicle Number:</strong>{{ $getRecords[0]['reg_number'] }}, <strong>Chasis
                        Number:</strong>{{ $getRecords[0]['chassis_number'] }}, <strong>Engine
                        Number:</strong>{{ $getRecords[0]['eng_number'] }}, <strong>Model:</strong>{{ $getRecords[0]['model_name'] }}, <strong>Model Year:</strong>{{ $getRecords[0]['model_year'] }},
                        <strong>Colour:</strong>{{ $getRecords[0]['car_color'] }}
                </p>
                <p>
                    to<strong> {{ $getRecords[0]['name'] }}</strong>, S/o Shri <strong>{{ $getRecords[0]['father_name'] }}</strong>, Address: <strong>{{ $getRecords[0]['address']}}</strong> , Aadhar Number:
                    <strong>{{ $getRecords[0]['aadhar'] }}</strong>, PAN: <strong>{{ $getRecords[0]['pan_card'] }}</strong>, on
                    <strong>{{ date('d/M/Y H:i:s', strtotime($getRecords[0]['created_at'] ))}}</strong>, for a total sum of
                    Rs.<strong>{{ $getRecords[0]['sell_amount'] }}/-</strong>.
                </p>
            </div>
            <div class="terms">
                <h3 class="section-title">Terms & Conditions:</h3>
                <ol>
                    <li>
                        All responsibilities related to the vehicle, including road traffic violations, legal obligations,
                        and any liabilities occurring before <strong>{{ date('d/M/Y H:i:s', strtotime($getRecords[0]['created_at'] ))}}</strong>, remain with <strong>Amit Kumar</strong>.
                    </li>
                    <li>
                        From <strong>{{ date('d/M/Y H:i:s', strtotime($getRecords[0]['created_at'] ))}}</strong>, all future responsibilities, including road traffic
                        movement, legal obligations, and any liabilities, will be solely borne by Buyer (<strong>{{ $getRecords[0]['name'] }}</strong>)
                        .
                    </li>
                    
                    <li>
                        Mr. <strong>{{ $getRecords[0]['name'] }}</strong> agrees to purchase the vehicle in its current condition, as inspected
                        and approved by him. The Seller (<strong>Amit Kumar</strong>), makes no warranties or guarantees, expressed or implied, regarding
                        the condition of the vehicle, except for any express warranties included in this Agreement. The
                        Buyer (<strong>{{ $getRecords[0]['name'] }}</strong>) acknowledges that the vehicle is sold "as-is" without any warranties from the Seller. This sale is final, and there is no provision for the return of the vehicle.
                    </li>
                    <li>The responsibility of the RC (Registration Certificate) lies with the DTO office, not the showroom.
                    </li>
                    <li>Once the RC (Registration Certificate) is updated online, ensure that the insurance is transferred
                        to your name. Otherwise, the showroom will not be responsible if a claim is denied.</li>
    
                </ol>
            </div>
            <!-- Signatures -->
            <div class="signatures">
                <div style="float: left">
                    <p>____________________</p>
                    <p>Buyer Sign</p>
                </div>
                <div style="float: right">
                    <p>____________________</p>
                    <p>Seller Sign</p>
                </div>
            </div>
        </div>
        

    </div>

</body>

</html>
